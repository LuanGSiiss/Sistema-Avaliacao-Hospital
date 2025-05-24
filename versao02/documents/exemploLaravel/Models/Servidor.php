<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servidor extends Model
{
    use HasFactory;

    //retorna um atribudo do servidor
    public function getAtributo($atributo) {
        return $_SERVER[$atributo];
    }

    public function getData() {
        date_default_timezone_set("America/Sao_Paulo");
        return date("d/m/y h:i:s a");
    }
}
