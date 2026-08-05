<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;


class CategoriaController extends Controller
{


    public function index()
    {

        $categorias = Categoria::orderBy('nome')
            ->get();


        return view(
            'admin.categorias.index',
            compact('categorias')
        );

    }





    public function create()
    {

        return view(
            'admin.categorias.create'
        );

    }





    public function store(Request $request)
    {

        $request->validate([

            'nome'=>'required|max:255',
            'descricao'=>'nullable',
            'ativo'=>'boolean'

        ]);



        Categoria::create([

            'nome'=>$request->nome,

            'descricao'=>$request->descricao,

            'ativo'=>$request->ativo ?? false

        ]);



        return redirect()
            ->route('categorias.index')
            ->with(
                'success',
                'Categoria criada com sucesso.'
            );

    }





    public function edit(Categoria $categoria)
    {

        return view(
            'admin.categorias.edit',
            compact('categoria')
        );

    }





    public function update(Request $request, Categoria $categoria)
    {

        $categoria->update([

            'nome'=>$request->nome,

            'descricao'=>$request->descricao,

            'ativo'=>$request->ativo ?? false

        ]);



        return redirect()
            ->route('categorias.index');

    }





    public function destroy(Categoria $categoria)
    {

        $categoria->delete();



        return redirect()
            ->route('categorias.index');

    }


}