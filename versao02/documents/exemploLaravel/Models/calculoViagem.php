<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class calculoViagem extends Model
{
    use HasFactory;

    public function calcularViagem($distancia, $consumo, $preco) {
        return ($distancia/$consumo)*$preco;
    }

}
