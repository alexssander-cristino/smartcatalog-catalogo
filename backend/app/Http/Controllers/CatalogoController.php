<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produto;
use App\Models\Carrossel;
use Illuminate\Http\Request;

class CatalogoController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | CATEGORIAS
        |--------------------------------------------------------------------------
        */

        $categorias = Categoria::where('ativo', true)
            ->orderBy('nome')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | CARROSSEL
        |--------------------------------------------------------------------------
        |
        | Busca somente os conteúdos ativos.
        | A ordem definida no painel será respeitada.
        |
        */

        $carrosseis = Carrossel::where('ativo', true)
            ->orderBy('ordem')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | PRODUTOS
        |--------------------------------------------------------------------------
        */

        $produtos = Produto::with([
                'categoria',
                'imagens'
            ])
            ->where('ativo', true);


        /*
        |--------------------------------------------------------------------------
        | FILTRO POR CATEGORIA
        |--------------------------------------------------------------------------
        */

        if ($request->filled('categoria')) {

            $produtos->where(
                'categoria_id',
                $request->categoria
            );

        }


        /*
        |--------------------------------------------------------------------------
        | BUSCA
        |--------------------------------------------------------------------------
        */

        if ($request->filled('busca')) {

            $busca = $request->busca;

            $produtos->where(function ($query) use ($busca) {

                $query->where(
                    'nome',
                    'ILIKE',
                    "%$busca%"
                )

                ->orWhere(
                    'marca',
                    'ILIKE',
                    "%$busca%"
                );

            });

        }


        /*
        |--------------------------------------------------------------------------
        | FINALIZA PRODUTOS
        |--------------------------------------------------------------------------
        */

        $produtos = $produtos
            ->orderBy('nome')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | ENVIA PARA O CATÁLOGO
        |--------------------------------------------------------------------------
        */

        return view(
            'catalogo.index',
            compact(
                'categorias',
                'produtos',
                'carrosseis'
            )
        );
    }


    public function produto(Produto $produto)
    {
        /*
        |--------------------------------------------------------------------------
        | RELACIONAMENTOS DO PRODUTO
        |--------------------------------------------------------------------------
        */

        $produto->load([
            'categoria',
            'imagens'
        ]);


        /*
        |--------------------------------------------------------------------------
        | PRODUTO INATIVO
        |--------------------------------------------------------------------------
        */

        if (!$produto->ativo) {

            abort(404);

        }


        /*
        |--------------------------------------------------------------------------
        | PÁGINA DO PRODUTO
        |--------------------------------------------------------------------------
        */

        return view(
            'catalogo.produto',
            compact('produto')
        );
    }
}