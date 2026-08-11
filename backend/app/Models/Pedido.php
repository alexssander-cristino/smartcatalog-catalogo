<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pedido extends Model
{
    use HasFactory;

    /**
     * Tabela do banco.
     */
    protected $table = 'pedidos';

    /**
     * Campos que podem ser preenchidos.
     */
    protected $fillable = [
        'user_id',
        'cliente',
        'numero',
        'observacao',
        'valor_total',
        'status',
        'emitido_em',
    ];

    /**
     * Conversões dos campos.
     */
    protected $casts = [
        'valor_total' => 'decimal:2',
        'emitido_em' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Usuário que emitiu o pedido
    |--------------------------------------------------------------------------
    */

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Itens do pedido
    |--------------------------------------------------------------------------
    */

    public function itens(): HasMany
    {
        return $this->hasMany(
            PedidoItem::class,
            'pedido_id'
        );
    }
}
