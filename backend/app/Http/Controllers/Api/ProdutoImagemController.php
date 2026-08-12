<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use App\Models\ProdutoImagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdutoImagemController extends Controller
{
    /**
     * Adicionar imagem
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

        $caminho = $request
            ->file('imagem')
            ->store('produtos', 'public');

        $imagem = ProdutoImagem::create([
            'produto_id' => $produto->id,
            'imagem' => $caminho,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Imagem adicionada com sucesso.',
            'data' => $imagem,
            'url' => asset(
                'storage/' . $caminho
            ),
        ], 201);
    }

    /**
     * Excluir imagem
     */
    public function destroy(
        ProdutoImagem $imagem
    ) {
        if ($imagem->imagem) {
            Storage::disk('public')->delete(
                $imagem->imagem
            );
        }

        $imagem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Imagem excluída com sucesso.',
        ]);
    }
}