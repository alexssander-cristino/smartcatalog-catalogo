<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrossel extends Model
{
    protected $table = 'carrosseis';

    protected $fillable = [
        'tipo',
        'arquivo',
        'titulo',
        'descricao',
        'ordem',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'ordem' => 'integer',
    ];
}