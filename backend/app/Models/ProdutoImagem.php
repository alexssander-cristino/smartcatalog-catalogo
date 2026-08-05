<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class ProdutoImagem extends Model
{
    use HasFactory;


    protected $fillable = [
        'produto_id',
        'imagem',
    ];



    protected $appends = [
        'url'
    ];



    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }




    public function getUrlAttribute()
    {
        return Storage::disk('public')
            ->url($this->imagem);
    }

}