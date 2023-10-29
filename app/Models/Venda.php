<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;

    protected $fillable = ['cliente_id', 'colaborador_id', 'valor_total'];

    public function colaborador() {
        return $this->belongsTo(Colaborador::class);
    }

    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }

    public function produtos() {
        return $this->belongsToMany(Produto::class, 'venda_produtos')->withPivot('quantidade');
    }
}
