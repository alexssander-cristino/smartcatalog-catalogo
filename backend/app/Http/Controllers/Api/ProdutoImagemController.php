<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use App\Models\ProdutoImagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProdutoImagemController extends Controller
{


    public function store(Request $request, Produto $produto)
    {


        $request->validate([

            'imagem' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ]

        ]);



        $arquivo = $request
            ->file('imagem')
            ->store(
                'produtos',
                'public'
            );



        $imagem = ProdutoImagem::create([

            'produto_id' => $produto->id,

            'imagem' => $arquivo

        ]);



        return response()->json([

            'message'=>'Imagem adicionada com sucesso.',

            'data'=>ProdutoImagem::find($imagem->id)

        ],201);


    }





    public function destroy(ProdutoImagem $imagem)
    {


        if(
            Storage::disk('public')
            ->exists($imagem->imagem)
        ){

            Storage::disk('public')
            ->delete($imagem->imagem);

        }



        $imagem->delete();



        return response()->json([

            'message'=>'Imagem removida com sucesso.'

        ]);


    }


}