<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissao extends Model
{
    use HasFactory;

    protected $fillable = ['nome'];

    public function funcoes() {
        return $this->belongsToMany(Funcao::class, 'funcao_permissaos');
    }

}
