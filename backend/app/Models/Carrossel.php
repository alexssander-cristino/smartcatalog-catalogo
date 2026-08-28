<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
    ];

    public function getUrlAttribute()
    {
        return Storage::disk('r2')->url(
            $this->arquivo
        );
    }
}