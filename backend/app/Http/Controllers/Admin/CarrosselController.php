<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carrossel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarrosselController extends Controller
{
    /**
     * Lista os conteúdos do carrossel.
     */
    public function index()
    {
        $carrosseis = Carrossel::orderBy('ordem')
            ->orderBy('id')
            ->get();

        return view(
            'admin.carrossel.index',
            compact('carrosseis')
        );
    }


    /**
     * Formulário para adicionar conteúdo.
     */
    public function create()
    {
        return view('admin.carrossel.create');
    }


    /**
     * Salva imagem ou vídeo.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tipo' => [
                'required',
                'in:imagem,video'
            ],

            'arquivo' => [
                'required',
                'file',
                'max:102400',
                'mimes:jpg,jpeg,png,webp,mp4,webm,mov'
            ],

            'titulo' => [
                'nullable',
                'string',
                'max:255'
            ],

            'descricao' => [
                'nullable',
                'string'
            ],

            'ordem' => [
                'nullable',
                'integer',
                'min:0'
            ],
        ]);


        $arquivo = $request
            ->file('arquivo')
            ->store(
                'carrossel',
                'public'
            );


        Carrossel::create([
            'tipo' => $request->tipo,

            'arquivo' => $arquivo,

            'titulo' => $request->titulo,

            'descricao' => $request->descricao,

            'ordem' => $request->ordem ?? 0,

            'ativo' => true,
        ]);


        return redirect()
            ->route('admin.carrossel.index')
            ->with(
                'success',
                'Conteúdo adicionado ao carrossel.'
            );
    }


    /**
     * Exclui o conteúdo.
     */
    public function destroy(Carrossel $carrossel)
    {
        if (
            $carrossel->arquivo &&
            Storage::disk('public')->exists(
                $carrossel->arquivo
            )
        ) {
            Storage::disk('public')->delete(
                $carrossel->arquivo
            );
        }


        $carrossel->delete();


        return redirect()
            ->route('admin.carrossel.index')
            ->with(
                'success',
                'Conteúdo removido do carrossel.'
            );
    }


    /**
     * Ativa ou desativa o conteúdo.
     */
    public function toggle(Carrossel $carrossel)
    {
        $carrossel->ativo = !$carrossel->ativo;

        $carrossel->save();


        return back()
            ->with(
                'success',
                $carrossel->ativo
                    ? 'Conteúdo ativado.'
                    : 'Conteúdo desativado.'
            );
    }
}