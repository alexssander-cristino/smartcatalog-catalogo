<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProdutoRequest;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{


    public function index(Request $request)
    {

        $query = Produto::with([
            'categoria',
            'imagens'
        ]);



        if ($request->filled('nome')) {

            $query->where(
                'nome',
                'ILIKE',
                '%' . $request->nome . '%'
            );

        }



        if ($request->filled('marca')) {

            $query->where(
                'marca',
                'ILIKE',
                '%' . $request->marca . '%'
            );

        }



        if ($request->filled('categoria_id')) {

            $query->where(
                'categoria_id',
                $request->categoria_id
            );

        }



        if ($request->has('ativo')) {

            $query->where(
                'ativo',
                $request->ativo
            );

        }



        if ($request->has('destaque')) {

            $query->where(
                'destaque',
                $request->destaque
            );

        }



        return response()->json(

            $query
            ->orderBy('nome')
            ->paginate(20)

        );

    }





    public function store(ProdutoRequest $request)
    {

        $produto = Produto::create(
            $request->validated()
        );


        return response()->json([

            'message'=>'Produto cadastrado com sucesso.',

            'data'=>Produto::with([
                'categoria',
                'imagens'
            ])
            ->find($produto->id)

        ],201);

    }





    public function show(string $id)
    {

        $produto = Produto::with([

            'categoria',
            'imagens'

        ])
        ->findOrFail($id);



        return response()->json($produto);

    }





    public function update(
        ProdutoRequest $request,
        string $id
    )
    {

        $produto = Produto::findOrFail($id);


        $produto->update(
            $request->validated()
        );



        return response()->json([

            'message'=>'Produto atualizado com sucesso.',

            'data'=>Produto::with([
                'categoria',
                'imagens'
            ])
            ->find($id)

        ]);

    }





    public function destroy(string $id)
    {

        $produto = Produto::with('imagens')
            ->findOrFail($id);



        foreach($produto->imagens as $imagem){


            if(Storage::disk('public')
                ->exists($imagem->imagem)){


                Storage::disk('public')
                    ->delete($imagem->imagem);

            }


        }



        $produto->delete();



        return response()->json([

            'message'=>'Produto removido com sucesso.'

        ]);

    }


}