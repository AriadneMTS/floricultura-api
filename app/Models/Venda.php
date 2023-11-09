<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;

    protected $fillable = ['cliente_id', 'colaborador_id', 'valor_total', 'metodo_pagamento', 'desconto'];
    protected $appends = [
        'formatted_created_at',
        'formatted_valor_total',
        'formatted_desconto',
    ];

    public function colaborador() {
        return $this->belongsTo(Colaborador::class);
    }

    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }

    public function produtos() {
        return $this->belongsToMany(Produto::class, 'venda_produtos')->withPivot('quantidade');
    }

    protected static function booted () {
        static::deleting(function(Venda $venda) {
             $venda->produtos()->detach();
        });
    }

    protected function formattedCreatedAt(): Attribute {
        return Attribute::make(
            get: fn () => formatCreatedAt($this->created_at),
        );
    }

    protected function formattedValorTotal(): Attribute {
        return Attribute::make(
            get: fn () => formatNumberToBRL($this->valor_total),
        );
    }

    protected function formattedDesconto(): Attribute {
        return Attribute::make(
            get: fn () => formatNumberToBRL($this->desconto),
        );
    }
}
