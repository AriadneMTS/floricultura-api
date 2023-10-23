<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'email', 'endereco', 'cpf','telefone'];

    public function compras() {
        return $this->hasMany(Venda::class);
    }

}
