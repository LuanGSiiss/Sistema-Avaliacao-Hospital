<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CalculadorImc;

class CalculadorImcController extends Controller
{
    public function mostraFormulario() {
        return view('imc.calculadorImc');
    }

    public function processarDados(Request $request) {
        $nome = $request->input('nome');
        $dataNascimento = $request->input('data-nascimento');
        $peso = $request->input('peso');
        $altura = $request->input('altura') / 100;

        $calculadorImcModel = new CalculadorImc;

        $imc = $calculadorImcModel->calcularImc($peso, $altura);
        $idade = $calculadorImcModel->calcularIdade($dataNascimento);
        $classificacao = $calculadorImcModel->calcularClassificacao($imc);

        $data['nome'] = $nome;
        $data['peso'] = $peso;
        $data['altura'] = $altura;
        $data['imc'] = $imc;
        $data['idade'] = $idade;
        $data['classificacao'] = $classificacao;

        return view('imc.resultadoImc', $data);
        
    }
}
