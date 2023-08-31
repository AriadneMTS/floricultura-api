<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class colaborador extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'cpf', 'telefone'];

    public function funcao() {
        return $this->hasOne(Funcao::class);
    }
}
