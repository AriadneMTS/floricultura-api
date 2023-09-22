<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;

    protected $fillable = ['valor_total'];

    public function colaborador(){
        return $this->hasOne(Colaborador::class);     
    }

    public function cliente(){
        return $this->hasOne(Cliente::class);     
    }

    public function produto(){
        return $this->belongsToMany(Produto::class);     
    }
}
