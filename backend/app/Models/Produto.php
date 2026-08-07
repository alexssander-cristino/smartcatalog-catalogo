<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoria_id',
        'nome',
        'codigo',
        'marca',
        'descricao',
        'preco',
        'estoque',
        'ativo',
        'destaque',
    ];

    protected $casts = [
        'preco' => 'decimal:2',
        'ativo' => 'boolean',
        'destaque' => 'boolean',
    ];

    public function categoria()
    {
        return $this->belongsTo(
            Categoria::class,
            'categoria_id'
        );
    }

    public function imagens()
    {
        return $this->hasMany(
            ProdutoImagem::class,
            'produto_id'
        );
    }
}