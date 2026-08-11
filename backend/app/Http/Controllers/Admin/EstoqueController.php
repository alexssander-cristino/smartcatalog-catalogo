<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MovimentacaoEstoque;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EstoqueController extends Controller
{
    /**
     * Lista o estoque dos produtos.
     */
    public function index()
    {
        $produtos = Produto::with('categoria')
            ->orderBy('nome')
            ->get();

        return view(
            'admin.estoque.index',
            compact('produtos')
        );
    }

    /**
     * Exibe o formulário de movimentação.
     */
    public function create(Produto $produto)
    {
        return view(
            'admin.estoque.create',
            compact('produto')
        );
    }

    /**
     * Registra uma movimentação.
     */
    public function store(
        Request $request,
        Produto $produto
    ) {
        /*
        |--------------------------------------------------------------------------
        | Validação dos dados
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'tipo' => 'required|in:entrada,saida,ajuste',

            'quantidade' => [
                'required',
                'integer',
                'min:1',
            ],

            'observacao' => 'nullable|string|max:1000',
        ], [
            'tipo.required' =>
                'Selecione o tipo de movimentação.',

            'tipo.in' =>
                'O tipo de movimentação selecionado é inválido.',

            'quantidade.required' =>
                'Informe a quantidade.',

            'quantidade.integer' =>
                'A quantidade deve ser um número inteiro.',

            'quantidade.min' =>
                'A quantidade deve ser maior que zero.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Quantidade solicitada
        |--------------------------------------------------------------------------
        */

        $quantidade = (int) $request->quantidade;

        /*
        |--------------------------------------------------------------------------
        | Verificação de saída maior que o estoque
        |--------------------------------------------------------------------------
        */

        if (
            $request->tipo === 'saida' &&
            $quantidade > $produto->estoque
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'quantidade' =>
                        'Não é possível retirar ' .
                        $quantidade .
                        ' unidade(s). ' .
                        'O estoque disponível é de ' .
                        $produto->estoque .
                        ' unidade(s).'
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Processamento da movimentação
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $request,
            $produto,
            $quantidade
        ) {
            $estoqueAnterior = $produto->estoque;

            /*
            |--------------------------------------------------------------------------
            | Entrada
            |--------------------------------------------------------------------------
            */

            if ($request->tipo === 'entrada') {

                $estoquePosterior =
                    $estoqueAnterior + $quantidade;
            }

            /*
            |--------------------------------------------------------------------------
            | Saída
            |--------------------------------------------------------------------------
            */

            elseif ($request->tipo === 'saida') {

                $estoquePosterior =
                    $estoqueAnterior - $quantidade;
            }

            /*
            |--------------------------------------------------------------------------
            | Ajuste
            |--------------------------------------------------------------------------
            */

            else {

                $estoquePosterior =
                    $quantidade;
            }

            /*
            |--------------------------------------------------------------------------
            | Atualiza estoque
            |--------------------------------------------------------------------------
            */

            $produto->update([
                'estoque' => $estoquePosterior,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Registra histórico
            |--------------------------------------------------------------------------
            */

            MovimentacaoEstoque::create([
                'produto_id' =>
                    $produto->id,

                'user_id' =>
                    Auth::id(),

                'tipo' =>
                    $request->tipo,

                'quantidade' =>
                    $quantidade,

                'estoque_anterior' =>
                    $estoqueAnterior,

                'estoque_posterior' =>
                    $estoquePosterior,

                'observacao' =>
                    $request->observacao,
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | Retorno
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.estoque.index')
            ->with(
                'success',
                'Estoque atualizado com sucesso.'
            );
    }

    /**
     * Histórico de movimentações.
     */
    public function historico(Produto $produto)
    {
        $movimentacoes = MovimentacaoEstoque::with('usuario')
            ->where(
                'produto_id',
                $produto->id
            )
            ->latest()
            ->get();

        return view(
            'admin.estoque.historico',
            compact(
                'produto',
                'movimentacoes'
            )
        );
    }
}

