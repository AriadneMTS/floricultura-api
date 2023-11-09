<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'email', 'endereco', 'cpf','telefone'];
    protected $appends = [
        'formatted_cpf',
    ];

    public function compras() {
        return $this->hasMany(Venda::class);
    }

    protected function formattedCpf(): Attribute {
        return Attribute::make(
            get: fn () => formatCnpjCpf($this->cpf),
        );
    }
}
