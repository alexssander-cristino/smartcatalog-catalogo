<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    /**
     * Listar produtos
     */
    public function index(Request $request)
    {
        $query = Produto::with('categoria', 'imagens');

        if ($request->filled('busca')) {
            $busca = $request->busca;

            $query->where(function ($q) use ($busca) {
                $q->where('nome', 'like', "%{$busca}%")
                    ->orWhere('descricao', 'like', "%{$busca}%");
            });
        }

        if ($request->filled('categoria_id')) {
            $query->where(
                'categoria_id',
                $request->categoria_id
            );
        }

        if ($request->filled('ativo')) {
            $query->where(
                'ativo',
                filter_var($request->ativo, FILTER_VALIDATE_BOOLEAN)
            );
        }

        $produtos = $query
            ->orderBy('nome')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $produtos,
        ]);
    }

    /**
     * Criar produto
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => [
                'required',
                'string',
                'max:255',
            ],

            'descricao' => [
                'nullable',
                'string',
            ],

            'preco' => [
                'required',
                'numeric',
                'min:0',
            ],

            'estoque' => [
                'required',
                'integer',
                'min:0',
            ],

            'categoria_id' => [
                'nullable',
                'integer',
                'exists:categorias,id',
            ],

            'ativo' => [
                'nullable',
                'boolean',
            ],
        ]);

        if (!isset($validated['ativo'])) {
            $validated['ativo'] = true;
        }

        $produto = Produto::create($validated);

        $produto->load('categoria', 'imagens');

        return response()->json([
            'success' => true,
            'message' => 'Produto criado com sucesso.',
            'data' => $produto,
        ], 201);
    }

    /**
     * Mostrar produto
     */
    public function show(Produto $produto)
    {
        $produto->load(
            'categoria',
            'imagens'
        );

        return response()->json([
            'success' => true,
            'data' => $produto,
        ]);
    }

    /**
     * Atualizar produto
     */
    public function update(Request $request, Produto $produto)
    {
        $validated = $request->validate([
            'nome' => [
                'required',
                'string',
                'max:255',
            ],

            'descricao' => [
                'nullable',
                'string',
            ],

            'preco' => [
                'required',
                'numeric',
                'min:0',
            ],

            'estoque' => [
                'required',
                'integer',
                'min:0',
            ],

            'categoria_id' => [
                'nullable',
                'integer',
                'exists:categorias,id',
            ],

            'ativo' => [
                'nullable',
                'boolean',
            ],
        ]);

        $produto->update($validated);

        $produto->load(
            'categoria',
            'imagens'
        );

        return response()->json([
            'success' => true,
            'message' => 'Produto atualizado com sucesso.',
            'data' => $produto,
        ]);
    }

    /**
     * Excluir produto
     */
    public function destroy(Produto $produto)
    {
        $produto->load('imagens');

        foreach ($produto->imagens as $imagem) {
            $imagem->delete();
        }

        $produto->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produto excluído com sucesso.',
        ]);
    }
}