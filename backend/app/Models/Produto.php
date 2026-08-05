<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'destaque',
        'ativo',
    ];

    protected $casts = [
        'preco' => 'decimal:2',
        'destaque' => 'boolean',
        'ativo' => 'boolean',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function imagens()
    {
        return $this->hasMany(ProdutoImagem::class);
    }
}