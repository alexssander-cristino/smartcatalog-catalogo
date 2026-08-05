<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produtos', function (Blueprint $table) {

            $table->id();

            $table->foreignId('categoria_id')
                  ->constrained('categorias')
                  ->cascadeOnDelete();

            $table->string('nome');

            $table->string('codigo')->unique();

            $table->string('marca')->nullable();

            $table->text('descricao')->nullable();

            $table->decimal('preco',10,2);

            $table->integer('estoque')->default(0);

            $table->boolean('destaque')->default(false);

            $table->boolean('ativo')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};