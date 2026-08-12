<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use Illuminate\Http\Request;

class EstoqueController extends Controller
{
    /**
     * Exibir estoque de todos os produtos
     */
    public function index()
    {
        $produtos = Produto::with('categoria')
            ->orderBy('nome')
            ->get();

        $totalUnidades = $produtos->sum('estoque');

        $estoqueBaixo = $produtos
            ->where('estoque', '<=', 5)
            ->count();

        $semEstoque = $produtos
            ->where('estoque', '<=', 0)
            ->count();

        return response()->json([
            'success' => true,

            'resumo' => [
                'total_unidades' => $totalUnidades,
                'produtos' => $produtos->count(),
                'estoque_baixo' => $estoqueBaixo,
                'sem_estoque' => $semEstoque,
            ],

            'data' => $produtos,
        ]);
    }

    /**
     * Exibir estoque de um produto
     */
    public function show(Produto $produto)
    {
        return response()->json([
            'success' => true,

            'data' => [
                'id' => $produto->id,
                'nome' => $produto->nome,
                'estoque' => $produto->estoque,
            ],
        ]);
    }

    /**
     * Entrada de estoque
     */
    public function entrada(
        Request $request,
        Produto $produto
    ) {
        $validated = $request->validate([
            'quantidade' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);

        $produto->increment(
            'estoque',
            $validated['quantidade']
        );

        $produto->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Entrada de estoque realizada com sucesso.',
            'data' => [
                'produto' => $produto,
                'estoque_anterior' =>
                    $produto->estoque - $validated['quantidade'],
                'quantidade' =>
                    $validated['quantidade'],
                'estoque_atual' =>
                    $produto->estoque,
            ],
        ]);
    }

    /**
     * Saída de estoque
     */
    public function saida(
        Request $request,
        Produto $produto
    ) {
        $validated = $request->validate([
            'quantidade' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);

        if ($produto->estoque < $validated['quantidade']) {
            return response()->json([
                'success' => false,
                'message' => 'Estoque insuficiente.',
                'estoque_atual' => $produto->estoque,
                'quantidade_solicitada' =>
                    $validated['quantidade'],
            ], 422);
        }

        $estoqueAnterior = $produto->estoque;

        $produto->decrement(
            'estoque',
            $validated['quantidade']
        );

        $produto->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Saída de estoque realizada com sucesso.',
            'data' => [
                'produto' => $produto,
                'estoque_anterior' => $estoqueAnterior,
                'quantidade' =>
                    $validated['quantidade'],
                'estoque_atual' =>
                    $produto->estoque,
            ],
        ]);
    }

    /**
     * Ajustar estoque para uma quantidade específica
     */
    public function ajustar(
        Request $request,
        Produto $produto
    ) {
        $validated = $request->validate([
            'estoque' => [
                'required',
                'integer',
                'min:0',
            ],
        ]);

        $estoqueAnterior = $produto->estoque;

        $produto->update([
            'estoque' => $validated['estoque'],
        ]);

        $produto->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Estoque ajustado com sucesso.',
            'data' => [
                'produto' => $produto,
                'estoque_anterior' => $estoqueAnterior,
                'estoque_atual' => $produto->estoque,
            ],
        ]);
    }
}