<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class funcao_permissao extends Model
{
    use HasFactory;
    
    public function Permissao() {
        return $this->hasOne(Permissao::class);
    }

    public function Funcao() {
        return $this->hasOne(Funcao::class);
    }

}
