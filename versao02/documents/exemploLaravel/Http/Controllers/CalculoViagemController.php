<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\calculoViagem;

class CalculoViagemController extends Controller
{
    public function mostraFormulario() {
        return view('viagem.formularioViagem');
    }

    public function processarDados(Request $request) {
        $distancia = $request->input('distancia');
        $consumo = $request->input('consumo-carro');
        $preco = $request->input('preco-gasolina');

        $calculoViagem = new calculoViagem;

        $custoViagem = $calculoViagem->calcularViagem($distancia, $consumo, $preco)/100;
        

        $data['custoViagem'] = $custoViagem;
    
        return view('viagem.resultadoViagem', $data);
        
    }
}
