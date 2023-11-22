<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = ['nome','valor','estoque','imagem_url', 'fornecedor_id'];
    protected $appends = ['formatted_valor'];

    public function fornecedor(){
        return $this->belongsTo(Fornecedor::class);
    }

    public function vendas() {
        return $this->belongsToMany(Venda::class, 'venda_produtos')->withPivot('quantidade');
    }

    protected function formattedValor(): Attribute {
        return Attribute::make(
            get: fn () => formatNumberToBRL($this->valor),
        );
    }
}
