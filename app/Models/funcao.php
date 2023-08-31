<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class funcao extends Model
{
    use HasFactory;

    protected $fillable = ['nome'];

    public function Permissao() {
        return $this->hasOne(Permissao::class);
    }


}
