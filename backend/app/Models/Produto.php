<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Produto extends Model
{


    use HasFactory;



    protected $fillable = [


        'sku',

        'nome',

        'marca',

        'descricao',

        'categoria_id',

        'preco',

        'preco_promocional',

        'estoque',

        'unidade',

        'ativo',

        'destaque',


    ];





    /*
    |--------------------------------------------------------------------------
    | Categoria do produto
    |--------------------------------------------------------------------------
    */


    public function categoria()
    {


        return $this->belongsTo(
            Categoria::class
        );


    }







    /*
    |--------------------------------------------------------------------------
    | Imagens do produto
    |--------------------------------------------------------------------------
    */


    public function imagens()
    {


        return $this->hasMany(
            ProdutoImagem::class
        );


    }






    /*
    |--------------------------------------------------------------------------
    | Retorna preço formatado
    |--------------------------------------------------------------------------
    */


    public function getPrecoFormatadoAttribute()
    {


        return number_format(
            $this->preco,
            2,
            ',',
            '.'
        );


    }








    /*
    |--------------------------------------------------------------------------
    | Retorna preço promocional ou normal
    |--------------------------------------------------------------------------
    */


    public function getPrecoAtualAttribute()
    {


        if(
            $this->preco_promocional &&
            $this->preco_promocional > 0
        ){

            return $this->preco_promocional;

        }



        return $this->preco;


    }






    /*
    |--------------------------------------------------------------------------
    | Verifica se está em promoção
    |--------------------------------------------------------------------------
    */


    public function getEmPromocaoAttribute()
    {


        return $this->preco_promocional 
            && $this->preco_promocional < $this->preco;


    }


}