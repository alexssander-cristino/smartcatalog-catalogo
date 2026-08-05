<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produto;

class ProdutoSeeder extends Seeder
{
    public function run(): void
    {
        Produto::insert([

            [
                'categoria_id' => 1,
                'nome' => 'Notebook Dell Inspiron',
                'codigo' => 'NOTE001',
                'marca' => 'Dell',
                'descricao' => 'Notebook para trabalho e estudos',
                'preco' => 3500.00,
                'estoque' => 10,
                'destaque' => true,
                'ativo' => true,
            ],

            [
                'categoria_id' => 2,
                'nome' => 'Mouse Logitech MX',
                'codigo' => 'MOUSE001',
                'marca' => 'Logitech',
                'descricao' => 'Mouse sem fio profissional',
                'preco' => 299.90,
                'estoque' => 25,
                'destaque' => false,
                'ativo' => true,
            ],

            [
                'categoria_id' => 3,
                'nome' => 'Mesa Escritório',
                'codigo' => 'MESA001',
                'marca' => 'Office',
                'descricao' => 'Mesa para escritório',
                'preco' => 850.00,
                'estoque' => 5,
                'destaque' => true,
                'ativo' => true,
            ]

        ]);
    }
}