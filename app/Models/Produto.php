<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = ['nome','valor','estoque','imagem_url', 'fornecedor_id'];

    public function fornecedor(){
        return $this->belongsTo(Fornecedor::class);
    }

    public function vendas() {
        return $this->belongsToMany(Venda::class, 'venda_produtos')->withPivot('quantidade');
    }
}
