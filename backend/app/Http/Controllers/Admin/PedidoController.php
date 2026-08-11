<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Produto;
use App\Models\MovimentacaoEstoque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    /**
     * Lista os pedidos.
     */
    public function index()
    {
        $pedidos = Pedido::with([
            'usuario',
            'itens.produto',
        ])
            ->latest()
            ->get();

        return view(
            'admin.pedidos.index',
            compact('pedidos')
        );
    }

    /**
     * Formulário para emitir um novo pedido.
     */
    public function create()
    {
        $produtos = Produto::with([
            'categoria',
            'imagens',
        ])
            ->where('ativo', true)
            ->orderBy('nome')
            ->get();

        return view(
            'admin.pedidos.create',
            compact('produtos')
        );
    }

    /**
     * Emite um novo pedido.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'cliente' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'observacao' => [
                    'nullable',
                    'string',
                    'max:1000',
                ],

                'produtos' => [
                    'required',
                    'array',
                    'min:1',
                ],

                'produtos.*.produto_id' => [
                    'required',
                    'integer',
                    'exists:produtos,id',
                ],

                'produtos.*.quantidade' => [
                    'required',
                    'integer',
                    'min:1',
                ],
            ],
            [
                'produtos.required' =>
                    'Adicione pelo menos um produto ao pedido.',

                'produtos.min' =>
                    'Adicione pelo menos um produto ao pedido.',

                'produtos.*.produto_id.required' =>
                    'Selecione um produto.',

                'produtos.*.produto_id.exists' =>
                    'O produto selecionado não existe.',

                'produtos.*.quantidade.required' =>
                    'Informe a quantidade.',

                'produtos.*.quantidade.integer' =>
                    'A quantidade deve ser um número inteiro.',

                'produtos.*.quantidade.min' =>
                    'A quantidade deve ser maior que zero.',
            ]
        );

        try {

            $pedido = DB::transaction(function () use ($validated) {

                /*
                |--------------------------------------------------------------------------
                | Número do pedido
                |--------------------------------------------------------------------------
                */

                $numero = 'PED-'
                    . now()->format('YmdHis')
                    . '-'
                    . random_int(100, 999);

                /*
                |--------------------------------------------------------------------------
                | Criar pedido
                |--------------------------------------------------------------------------
                */

                $pedido = Pedido::create([
                    'user_id' => Auth::id(),

                    'numero' => $numero,

                    // SALVA O NOME DIGITADO
                    'cliente' => $validated['cliente'] ?? null,

                    'observacao' =>
                        $validated['observacao'] ?? null,

                    'valor_total' => 0,

                    'status' => 'emitido',

                    'emitido_em' => now(),
                ]);

                $valorTotal = 0;

                /*
                |--------------------------------------------------------------------------
                | Produtos
                |--------------------------------------------------------------------------
                */

                foreach ($validated['produtos'] as $item) {

                    $produto = Produto::lockForUpdate()
                        ->find($item['produto_id']);

                    if (!$produto) {
                        throw new \Exception(
                            'Produto não encontrado.'
                        );
                    }

                    $quantidade = (int) $item['quantidade'];

                    /*
                    |--------------------------------------------------------------------------
                    | Verificar estoque
                    |--------------------------------------------------------------------------
                    */

                    if ($quantidade > $produto->estoque) {

                        throw new \Exception(
                            "Estoque insuficiente para \"{$produto->nome}\". "
                            . "Disponível: {$produto->estoque}. "
                            . "Solicitado: {$quantidade}."
                        );
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Preço
                    |--------------------------------------------------------------------------
                    */

                    $precoUnitario = $produto->preco;

                    if (
                        $produto->preco_promocional &&
                        $produto->preco_promocional > 0 &&
                        $produto->preco_promocional < $produto->preco
                    ) {
                        $precoUnitario =
                            $produto->preco_promocional;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Subtotal
                    |--------------------------------------------------------------------------
                    */

                    $subtotal =
                        $precoUnitario * $quantidade;

                    $valorTotal += $subtotal;

                    /*
                    |--------------------------------------------------------------------------
                    | Criar item
                    |--------------------------------------------------------------------------
                    */

                    PedidoItem::create([
                        'pedido_id' => $pedido->id,

                        'produto_id' => $produto->id,

                        'quantidade' => $quantidade,

                        'preco_unitario' => $precoUnitario,

                        'subtotal' => $subtotal,
                    ]);

                    /*
                    |--------------------------------------------------------------------------
                    | Estoque
                    |--------------------------------------------------------------------------
                    */

                    $estoqueAnterior =
                        $produto->estoque;

                    $estoquePosterior =
                        $estoqueAnterior - $quantidade;

                    $produto->update([
                        'estoque' => $estoquePosterior,
                    ]);

                    /*
                    |--------------------------------------------------------------------------
                    | Movimentação
                    |--------------------------------------------------------------------------
                    */

                    MovimentacaoEstoque::create([
                        'produto_id' => $produto->id,

                        'user_id' => Auth::id(),

                        'tipo' => 'saida',

                        'quantidade' => $quantidade,

                        'estoque_anterior' =>
                            $estoqueAnterior,

                        'estoque_posterior' =>
                            $estoquePosterior,

                        'observacao' =>
                            'Saída referente ao pedido '
                            . $pedido->numero,
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Atualizar total
                |--------------------------------------------------------------------------
                */

                $pedido->update([
                    'valor_total' => $valorTotal,
                ]);

                return $pedido;
            });

            return redirect()
                ->route(
                    'admin.pedidos.show',
                    $pedido
                )
                ->with(
                    'success',
                    'Pedido emitido com sucesso.'
                );

        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->withErrors([
                    'pedido' => $e->getMessage(),
                ]);
        }
    }

    /**
     * Exibe um pedido.
     */
    public function show(Pedido $pedido)
    {
        $pedido->load([
            'usuario',
            'itens.produto',
        ]);

        return view(
            'admin.pedidos.show',
            compact('pedido')
        );
    }

    /**
     * Cancela um pedido e devolve o estoque.
     */
    public function destroy(Pedido $pedido)
    {
        if ($pedido->status === 'cancelado') {

            return redirect()
                ->route('admin.pedidos.index')
                ->with(
                    'error',
                    'Este pedido já está cancelado.'
                );
        }

        DB::transaction(function () use ($pedido) {

            $pedido->load('itens.produto');

            foreach ($pedido->itens as $item) {

                $produto = Produto::lockForUpdate()
                    ->find($item->produto_id);

                if (!$produto) {
                    continue;
                }

                $estoqueAnterior =
                    $produto->estoque;

                $estoquePosterior =
                    $estoqueAnterior + $item->quantidade;

                $produto->update([
                    'estoque' => $estoquePosterior,
                ]);

                MovimentacaoEstoque::create([
                    'produto_id' => $produto->id,

                    'user_id' => Auth::id(),

                    'tipo' => 'entrada',

                    'quantidade' => $item->quantidade,

                    'estoque_anterior' =>
                        $estoqueAnterior,

                    'estoque_posterior' =>
                        $estoquePosterior,

                    'observacao' =>
                        'Estorno do pedido '
                        . $pedido->numero,
                ]);
            }

            $pedido->update([
                'status' => 'cancelado',
            ]);
        });

        return redirect()
            ->route('admin.pedidos.index')
            ->with(
                'success',
                'Pedido cancelado e estoque restaurado com sucesso.'
            );
    }
}
