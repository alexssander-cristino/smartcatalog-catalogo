<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('produtos', function (Blueprint $table) {


        $table->string('sku')
            ->nullable()
            ->after('id');


        $table->decimal('preco_promocional',10,2)
            ->nullable()
            ->after('preco');


        $table->string('unidade')
            ->default('UN')
            ->after('estoque');


    });
}
};
