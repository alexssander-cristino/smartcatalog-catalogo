<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProdutoImagem extends Model
{
    protected $table = 'produto_imagens';

    protected $fillable = [
        'produto_id',
        'imagem',
    ];

    public function produto()
    {
        return $this->belongsTo(
            Produto::class,
            'produto_id'
        );
    }

    public function getUrlAttribute()
    {
        return Storage::disk('r2')->url(
            $this->imagem
        );
    }
}