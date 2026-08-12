<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Pedido;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProdutos = Produto::count();

        $produtosAtivos = Produto::where(
            'ativo',
            true
        )->count();

        $estoqueTotal = Produto::sum('estoque');

        $produtosEstoqueBaixo = Produto::where(
            'estoque',
            '<=',
            5
        )
            ->orderBy('estoque')
            ->get([
                'id',
                'nome',
                'estoque',
            ]);

        $estoqueBaixo = $produtosEstoqueBaixo->count();

        $totalCategorias = Categoria::count();

        $totalPedidos = Pedido::count();

        $pedidosEmitidos = Pedido::where(
            'status',
            'emitido'
        )->count();

        $pedidosCancelados = Pedido::where(
            'status',
            'cancelado'
        )->count();

        $valorPedidosEmitidos = Pedido::where(
            'status',
            'emitido'
        )->sum('valor_total');

        $ultimosPedidos = Pedido::orderByDesc(
            'created_at'
        )
            ->limit(8)
            ->get([
                'id',
                'numero',
                'status',
                'valor_total',
                'created_at',
            ]);

        return response()->json([
            'success' => true,

            'data' => [
                'total_produtos' => $totalProdutos,
                'produtos_ativos' => $produtosAtivos,

                'estoque_total' => $estoqueTotal,
                'estoque_baixo' => $estoqueBaixo,

                'total_categorias' => $totalCategorias,

                'total_pedidos' => $totalPedidos,
                'pedidos_emitidos' => $pedidosEmitidos,
                'pedidos_cancelados' => $pedidosCancelados,

                'valor_pedidos_emitidos' =>
                    $valorPedidosEmitidos,

                'produtos_estoque_baixo' =>
                    $produtosEstoqueBaixo,

                'ultimos_pedidos' =>
                    $ultimosPedidos,
            ],
        ]);
    }
}