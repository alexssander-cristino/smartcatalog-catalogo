<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class ProdutoImagem extends Model
{
    use HasFactory;


    protected $table = 'produto_imagens';



    protected $fillable = [
        'produto_id',
        'imagem',
    ];



    protected $appends = [
        'url'
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
        if (!$this->imagem) {
            return null;
        }


        return asset(
            'storage/' . $this->imagem
        );
    }

}