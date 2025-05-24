<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CalculadorImc extends Model
{
    use HasFactory;

    public function calcularImc($peso, $altura) {
        return $peso / ($altura * $altura);
    }

    public function calcularIdade($dataNascimento) {
            date_default_timezone_set('America/Sao_Paulo');
            // Converte a string "dd/mm/yyyy" para o formato "yyyy-mm-dd"
            
            $dataFormatada = Carbon::createFromFormat('Y-m-d', $dataNascimento);

            // Calcula a idade com base na data atual
            $idade = intval($dataFormatada->diff(Carbon::now())->y);
        
        return $idade;
    }

    public function calcularClassificacao($imc) {
        $classificao = '';
        
        switch (true) {
            case ($imc < 18.5):
                $classificao = "Abaixo do peso";
                break;
            case ($imc < 24.9):
                $classificao = "Peso normal";
                break;
            case ($imc < 29.9):
                $classificao = "Acima do peso (sobrepeso)";
                break;
            case ($imc < 34.9):
                $classificao = "Obsidade I";
                break;
            case ($imc < 39.9):
                $classificao = "Obsidade II";
                break;
            default:
            $classificao = "Obsidade III";
        }

        return $classificao;
    }
}
