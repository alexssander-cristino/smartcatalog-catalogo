<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use App\Models\Categoria;


class DashboardController extends Controller
{

    public function index()
    {

        $dados = [

            'produtos' => Produto::count(),

            'categorias' => Categoria::count(),

            'ativos' => Produto::where(
                'ativo',
                true
            )->count(),

            'estoque_baixo' => Produto::where(
                'estoque',
                '<=',
                5
            )->count(),

        ];


        return view(
            'admin.dashboard',
            compact('dados')
        );

    }

}