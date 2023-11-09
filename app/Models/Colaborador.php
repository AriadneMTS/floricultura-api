<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Colaborador extends Authenticable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['nome', 'cpf', 'telefone', 'funcao_id', 'email', 'password'];
    protected $hidden = ["password"];
    protected $appends = [
        'formatted_cpf',
    ];

    public function funcao() {
        return $this->belongsTo(Funcao::class);
    }

    public function vendas() {
        return $this->hasMany(Venda::class);
    }

    protected function formattedCpf(): Attribute {
        return Attribute::make(
            get: fn () => formatCnpjCpf($this->cpf),
        );
    }
}
