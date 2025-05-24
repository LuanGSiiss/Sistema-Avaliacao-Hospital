<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class calculoSono extends Model
{
    use HasFactory;

    public function calcularClassificacao($horas) {
        $classificao = '';
        
        switch (true) {
            case ($horas >= 7):
                $classificao = "Sono Adequado";
                break;
            case ($horas >= 5):
                $classificao = "Sono Insuficiente, mas aceitável";
                break;
            default:
            $classificao = "Sono insuficiente";
        }

        return $classificao;
    }
}
