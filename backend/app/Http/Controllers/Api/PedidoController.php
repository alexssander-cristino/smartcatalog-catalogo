<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * Listar pedidos
     *
     * GET /api/pedidos
     */
    public function index(Request $request)
    {
        $query = Pedido::query();

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        $pedidos = $query
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $pedidos,
        ]);
    }

    /**
     * Mostrar pedido
     *
     * GET /api/pedidos/{pedido}
     */
    public function show(Pedido $pedido)
    {
        return response()->json([
            'success' => true,
            'data' => $pedido,
        ]);
    }

    /**
     * Criar pedido
     *
     * POST /api/pedidos
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'numero' => [
                'nullable',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'in:emitido,cancelado',
            ],

            'valor_total' => [
                'required',
                'numeric',
                'min:0',
            ],
        ]);

        if (empty($validated['numero'])) {
            $validated['numero'] =
                'PED-' . now()->format('YmdHis');
        }

        $pedido = Pedido::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pedido criado com sucesso.',
            'data' => $pedido,
        ], 201);
    }

    /**
     * Atualizar pedido
     *
     * PUT /api/pedidos/{pedido}
     */
    public function update(
        Request $request,
        Pedido $pedido
    ) {
        $validated = $request->validate([
            'numero' => [
                'required',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'in:emitido,cancelado',
            ],

            'valor_total' => [
                'required',
                'numeric',
                'min:0',
            ],
        ]);

        $pedido->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pedido atualizado com sucesso.',
            'data' => $pedido->fresh(),
        ]);
    }

    /**
     * Excluir pedido
     *
     * DELETE /api/pedidos/{pedido}
     */
    public function destroy(Pedido $pedido)
    {
        $pedido->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pedido excluído com sucesso.',
        ]);
    }
}