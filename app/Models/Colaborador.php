<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Colaborador extends Authenticable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['nome', 'cpf', 'telefone', 'funcao_id', 'email', 'password'];
    protected $hidden = ["password"];

    public function funcao() {
        return $this->belongsTo(Funcao::class);
    }

    public function vendas() {
        return $this->hasMany(Venda::class);
    }
}
