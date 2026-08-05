<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        Categoria::insert([

            [
                'nome'=>'Eletrônicos',
                'descricao'=>'Produtos eletrônicos',
                'ativo'=>true
            ],

            [
                'nome'=>'Informática',
                'descricao'=>'Computadores e acessórios',
                'ativo'=>true
            ],

            [
                'nome'=>'Móveis',
                'descricao'=>'Móveis em geral',
                'ativo'=>true
            ]

        ]);
    }
}