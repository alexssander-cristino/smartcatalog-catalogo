<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Listar categorias
     */
    public function index()
    {
        $categorias = Categoria::orderBy('nome')->get();

        return response()->json([
            'success' => true,
            'data' => $categorias,
        ]);
    }

    /**
     * Criar categoria
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => [
                'required',
                'string',
                'max:255',
                'unique:categorias,nome',
            ],
            'descricao' => [
                'nullable',
                'string',
            ],
        ]);

        $categoria = Categoria::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Categoria criada com sucesso.',
            'data' => $categoria,
        ], 201);
    }

    /**
     * Mostrar categoria
     */
    public function show(Categoria $categoria)
    {
        $categoria->load('produtos');

        return response()->json([
            'success' => true,
            'data' => $categoria,
        ]);
    }

    /**
     * Atualizar categoria
     */
    public function update(Request $request, Categoria $categoria)
    {
        $validated = $request->validate([
            'nome' => [
                'required',
                'string',
                'max:255',
                'unique:categorias,nome,' . $categoria->id,
            ],
            'descricao' => [
                'nullable',
                'string',
            ],
        ]);

        $categoria->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Categoria atualizada com sucesso.',
            'data' => $categoria->fresh(),
        ]);
    }

    /**
     * Excluir categoria
     */
    public function destroy(Categoria $categoria)
    {
        if ($categoria->produtos()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Não é possível excluir uma categoria que possui produtos.',
            ], 422);
        }

        $categoria->delete();

        return response()->json([
            'success' => true,
            'message' => 'Categoria excluída com sucesso.',
        ]);
    }
}