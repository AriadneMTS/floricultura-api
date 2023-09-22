<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda_produto extends Model
{
    use HasFactory;

    public function venda(){
        return $this->hasOne(Venda::class);     
    }

    public function produto(){
        return $this->belongsToMany(Produto::class);     
    }
}
