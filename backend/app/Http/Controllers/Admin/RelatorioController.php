<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | FILTRO DE DATAS
        |--------------------------------------------------------------------------
        */

        $dataInicio = $request->input('data_inicio');
        $dataFim = $request->input('data_fim');


        /*
        |--------------------------------------------------------------------------
        | QUERY BASE DOS PEDIDOS
        |--------------------------------------------------------------------------
        */

        $pedidosQuery = Pedido::query();

        if ($dataInicio) {
            $pedidosQuery->whereDate(
                'created_at',
                '>=',
                $dataInicio
            );
        }

        if ($dataFim) {
            $pedidosQuery->whereDate(
                'created_at',
                '<=',
                $dataFim
            );
        }


        /*
        |--------------------------------------------------------------------------
        | PRODUTOS
        |--------------------------------------------------------------------------
        */

        $totalProdutos = Produto::count();

        $produtosAtivos = Produto::where(
            'ativo',
            true
        )->count();

        $produtosInativos = Produto::where(
            'ativo',
            false
        )->count();


        /*
        |--------------------------------------------------------------------------
        | ESTOQUE
        |--------------------------------------------------------------------------
        */

        $quantidadeTotalEstoque = Produto::sum(
            'estoque'
        );

        $estoqueBaixo = Produto::where(
            'estoque',
            '<=',
            5
        )->count();


        /*
        |--------------------------------------------------------------------------
        | VALOR TOTAL DO ESTOQUE
        |--------------------------------------------------------------------------
        |
        | Considera:
        |
        | estoque x preco
        |
        */

        $valorTotalEstoque = Produto::select(
            DB::raw(
                'COALESCE(SUM(estoque * preco), 0) as total'
            )
        )->value('total');


        /*
        |--------------------------------------------------------------------------
        | PEDIDOS
        |--------------------------------------------------------------------------
        */

        $totalPedidos = (clone $pedidosQuery)->count();

        $pedidosEmitidos = (clone $pedidosQuery)
            ->where('status', 'emitido')
            ->count();

        $pedidosCancelados = (clone $pedidosQuery)
            ->where('status', 'cancelado')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | VALOR DOS PEDIDOS EMITIDOS
        |--------------------------------------------------------------------------
        */

        $valorPedidosEmitidos = (clone $pedidosQuery)
            ->where('status', 'emitido')
            ->sum('valor_total');


        /*
        |--------------------------------------------------------------------------
        | PRODUTOS MAIS PEDIDOS
        |--------------------------------------------------------------------------
        |
        | Utiliza a tabela pedido_itens.
        |
        | Campos esperados:
        |
        | pedido_id
        | produto_id
        | quantidade
        |
        */

        $produtosMaisPedidos = collect();

        try {

            $produtosMaisPedidos = Produto::query()
                ->select(
                    'produtos.*',
                    DB::raw(
                        'COALESCE(SUM(pedido_itens.quantidade), 0) as quantidade_vendida'
                    )
                )
                ->join(
                    'pedido_itens',
                    'pedido_itens.produto_id',
                    '=',
                    'produtos.id'
                )
                ->join(
                    'pedidos',
                    'pedidos.id',
                    '=',
                    'pedido_itens.pedido_id'
                )
                ->where(
                    'pedidos.status',
                    'emitido'
                )
                ->when(
                    $dataInicio,
                    function ($query) use ($dataInicio) {
                        $query->whereDate(
                            'pedidos.created_at',
                            '>=',
                            $dataInicio
                        );
                    }
                )
                ->when(
                    $dataFim,
                    function ($query) use ($dataFim) {
                        $query->whereDate(
                            'pedidos.created_at',
                            '<=',
                            $dataFim
                        );
                    }
                )
                ->groupBy(
                    'produtos.id'
                )
                ->orderByDesc(
                    'quantidade_vendida'
                )
                ->limit(10)
                ->get();

        } catch (\Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | CASO A TABELA DE ITENS AINDA NÃO EXISTA
            |--------------------------------------------------------------------------
            |
            | Evita quebrar a página inteira do relatório.
            |
            */

            $produtosMaisPedidos = collect();
        }


        /*
        |--------------------------------------------------------------------------
        | PRODUTOS COM ESTOQUE BAIXO
        |--------------------------------------------------------------------------
        */

        $produtosEstoqueBaixo = Produto::with(
            'categoria'
        )
            ->where(
                'estoque',
                '<=',
                5
            )
            ->orderBy(
                'estoque'
            )
            ->get();


        /*
        |--------------------------------------------------------------------------
        | PRODUTOS POR CATEGORIA
        |--------------------------------------------------------------------------
        */

        $produtosPorCategoria = Categoria::withCount(
            'produtos'
        )
            ->orderBy(
                'nome'
            )
            ->get();


        /*
        |--------------------------------------------------------------------------
        | ÚLTIMOS PEDIDOS
        |--------------------------------------------------------------------------
        */

        $ultimosPedidos = (clone $pedidosQuery)
            ->orderByDesc(
                'created_at'
            )
            ->limit(10)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | RETORNO DA VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.relatorios.index',
            compact(
                'dataInicio',
                'dataFim',

                'totalProdutos',
                'produtosAtivos',
                'produtosInativos',

                'quantidadeTotalEstoque',
                'estoqueBaixo',
                'valorTotalEstoque',

                'totalPedidos',
                'pedidosEmitidos',
                'pedidosCancelados',
                'valorPedidosEmitidos',

                'produtosMaisPedidos',
                'produtosEstoqueBaixo',
                'produtosPorCategoria',
                'ultimosPedidos'
            )
        );
    }
}

