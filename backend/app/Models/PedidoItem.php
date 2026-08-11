<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PedidoItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedido_id',
        'produto_id',
        'quantidade',
        'preco_unitario',
        'subtotal',
    ];

    protected $casts = [
        'preco_unitario' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Pedido
    |--------------------------------------------------------------------------
    */

    public function pedido()
    {
        return $this->belongsTo(
            Pedido::class
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Produto
    |--------------------------------------------------------------------------
    */

    public function produto()
    {
        return $this->belongsTo(
            Produto::class
        );
    }
}