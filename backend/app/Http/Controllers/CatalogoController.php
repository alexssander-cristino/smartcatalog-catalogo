<?php


namespace App\Http\Controllers;


use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\Request;



class CatalogoController extends Controller
{


    public function index(Request $request)
    {


        $categorias = Categoria::where('ativo', true)
            ->orderBy('nome')
            ->get();



        $produtos = Produto::with([
                'categoria',
                'imagens'
            ])
            ->where('ativo', true);



        if($request->filled('categoria')){


            $produtos->where(
                'categoria_id',
                $request->categoria
            );


        }



        if($request->filled('busca')){


            $busca = $request->busca;


            $produtos->where(function($query) use ($busca){


                $query->where('nome','ILIKE',"%$busca%")
                    ->orWhere('marca','ILIKE',"%$busca%");


            });


        }



        $produtos = $produtos
            ->orderBy('nome')
            ->get();



        return view(
            'catalogo.index',
            compact(
                'categorias',
                'produtos'
            )
        );


    }





    public function produto(Produto $produto)
    {


        $produto->load([
            'categoria',
            'imagens'
        ]);



        if(!$produto->ativo){

            abort(404);

        }



        return view(
            'catalogo.produto',
            compact('produto')
        );


    }



}