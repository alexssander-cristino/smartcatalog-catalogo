<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Adiciona o cliente ao pedido.
     */
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {

            $table->foreignId('cliente_id')
                ->nullable()
                ->after('user_id')
                ->constrained('clientes')
                ->nullOnDelete();

        });
    }

    /**
     * Remove o cliente do pedido.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {

            $table->dropForeign([
                'cliente_id'
            ]);

            $table->dropColumn('cliente_id');

        });
    }
};

