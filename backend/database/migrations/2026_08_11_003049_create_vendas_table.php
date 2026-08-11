<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa a migration.
     */
    public function up(): void
    {
        Schema::create('vendas', function (Blueprint $table) {

            $table->id();

            $table->string('numero')->unique();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('cliente_nome')
                ->nullable();

            $table->decimal('total', 12, 2)
                ->default(0);

            $table->string('status')
                ->default('finalizada');

            $table->text('observacao')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverte a migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendas');
    }
};