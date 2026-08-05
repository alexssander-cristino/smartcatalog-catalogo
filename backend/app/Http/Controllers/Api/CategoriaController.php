<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        $query = Categoria::query();

        if ($request->filled('nome')) {
            $query->where('nome', 'ILIKE', '%' . $request->nome . '%');
        }

        if ($request->has('ativo')) {
            $query->where('ativo', $request->ativo);
        }

        return response()->json(
            $query->orderBy('nome')->get()
        );
    }

    public function store(CategoriaRequest $request)
    {
        $categoria = Categoria::create($request->validated());

        return response()->json([
            'message' => 'Categoria cadastrada com sucesso.',
            'data' => $categoria
        ], 201);
    }

    public function show(string $id)
    {
        $categoria = Categoria::findOrFail($id);

        return response()->json($categoria);
    }

    public function update(CategoriaRequest $request, string $id)
    {
        $categoria = Categoria::findOrFail($id);

        $categoria->update($request->validated());

        return response()->json([
            'message' => 'Categoria atualizada com sucesso.',
            'data' => $categoria
        ]);
    }

    public function destroy(string $id)
    {
        $categoria = Categoria::findOrFail($id);

        $categoria->delete();

        return response()->json([
            'message' => 'Categoria removida com sucesso.'
        ]);
    }
}