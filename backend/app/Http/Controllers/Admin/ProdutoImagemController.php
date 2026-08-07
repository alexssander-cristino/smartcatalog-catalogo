<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use App\Models\ProdutoImagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdutoImagemController extends Controller
{
    /**
     * Adiciona uma imagem ao produto.
     */
    public function store(
        Request $request,
        Produto $produto
    ) {
        $request->validate([
            'imagem' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        $arquivo = $request
            ->file('imagem')
            ->store(
                'produtos',
                'public'
            );

        ProdutoImagem::create([
            'produto_id' => $produto->id,
            'imagem' => $arquivo,
        ]);

        return redirect()
            ->route(
                'admin.produtos.edit',
                $produto
            )
            ->with(
                'success',
                'Imagem adicionada com sucesso.'
            );
    }


    /**
     * Exclui uma imagem.
     */
    public function destroy(
        ProdutoImagem $imagem
    ) {
        $produto = $imagem->produto;

        if (
            $imagem->imagem &&
            Storage::disk('public')->exists(
                $imagem->imagem
            )
        ) {
            Storage::disk('public')
                ->delete($imagem->imagem);
        }

        $imagem->delete();

        return redirect()
            ->route(
                'admin.produtos.edit',
                $produto
            )
            ->with(
                'success',
                'Imagem removida com sucesso.'
            );
    }
}
