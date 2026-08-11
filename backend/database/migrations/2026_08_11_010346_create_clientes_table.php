<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Criar tabela de clientes.
     */
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {

            $table->id();

            $table->string('nome');

            $table->string('email')
                ->nullable();

            $table->string('telefone')
                ->nullable();

            $table->string('cpf')
                ->nullable();

            $table->string('endereco')
                ->nullable();

            $table->string('cidade')
                ->nullable();

            $table->string('estado', 2)
                ->nullable();

            $table->string('cep')
                ->nullable();

            $table->text('observacao')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Remover tabela de clientes.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
