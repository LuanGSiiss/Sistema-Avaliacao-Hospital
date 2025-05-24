<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\calculoSono;

class CalculoSonoController extends Controller
{
    public function mostraFormulario() {
        return view('sono.formularioSono');
    }

    public function processarDados(Request $request) {
        $horas = $request->input('horas-sono');
        
        $calculoSono = new calculoSono;

        $classificao = $calculoSono->calcularClassificacao($horas);
        

        $data['classificao'] = $classificao;

        return view('sono.resultadoSono', $data);
        
    }
}
