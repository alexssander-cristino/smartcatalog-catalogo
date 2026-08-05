<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use App\Models\Categoria;

class DashboardController extends Controller
{

    public function index()
    {

        return response()->json([

            'categorias' => Categoria::count(),

            'produtos' => Produto::count(),

            'produtos_ativos' => Produto::where(
                'ativo',
                true
            )->count(),


            'produtos_destaque' => Produto::where(
                'destaque',
                true
            )
            ->with('categoria')
            ->get(),


            'estoque_baixo' => Produto::where(
                'estoque',
                '<=',
                5
            )
            ->with('categoria')
            ->get(),

        ]);

    }

}