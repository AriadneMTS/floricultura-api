<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcao extends Model
{
    use HasFactory;

    protected $fillable = ['nome'];

    public function permissoes() {
        return $this->belongsToMany(Permissao::class, 'funcao_permissaos');
    }

    public function colaboradores() {
        return $this->hasMany(Colaborador:: class);
    }

    protected static function booted () {
        static::deleting(function(Funcao $funcao) {
             $funcao->permissoes()->detach();
        });
    }
}
