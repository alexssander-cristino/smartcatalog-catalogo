<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use App\Models\Categoria;

class DashboardController extends Controller
{

    public function index()
    {


        $totalProdutos = Produto::count();



        $totalCategorias = Categoria::where('ativo', true)
            ->count();



        $categoriasInativas = Categoria::where('ativo', false)
            ->count();




        $produtosAtivos = Produto::where('ativo', true)
            ->count();




        $produtosInativos = Produto::where('ativo', false)
            ->count();




        $estoqueBaixo = Produto::where('estoque', '<=', 5)
            ->count();




        $produtosDestaque = Produto::where('destaque', true)
            ->count();




        $ultimosProdutos = Produto::with('categoria')
            ->latest()
            ->limit(5)
            ->get();





        return view(
            'admin.dashboard',
            compact(
                'totalProdutos',
                'totalCategorias',
                'categoriasInativas',
                'produtosAtivos',
                'produtosInativos',
                'estoqueBaixo',
                'produtosDestaque',
                'ultimosProdutos'
            )
        );


    }

}