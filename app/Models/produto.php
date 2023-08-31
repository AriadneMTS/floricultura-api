<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class produto extends Model
{
    use HasFactory;

    protected $fillable = ['nome','valor','estoque','imagem_url'];

    public function fornecedor(){
        return $this->belongsTo(Fornecedor::class);
    }
}
