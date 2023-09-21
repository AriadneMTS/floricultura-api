<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'cpf', 'telefone', 'funcao_id'];

    public function funcao() {
        return $this->belongsTo(Funcao::class);
    }
}
