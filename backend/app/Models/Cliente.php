<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    use HasFactory;

    /**
     * Tabela utilizada pelo model.
     */
    protected $table = 'clientes';

    /**
     * Campos que podem ser preenchidos.
     */
    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'cpf',
        'endereco',
        'cidade',
        'estado',
        'cep',
        'observacao',
    ];

    /**
     * Um cliente pode possuir vários pedidos.
     */
    public function pedidos(): HasMany
    {
        return $this->hasMany(
            Pedido::class,
            'cliente_id'
        );
    }
}

