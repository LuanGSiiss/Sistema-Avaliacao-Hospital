<?php

$routes = [
    'GET' => [
        '/' => 'HomeController@index',
        '/consultaAvaliacoes' => 'ConsultaAvaliacoesController@exibirConsulta',
        '/consultaAvaliacoes/buscar' => 'ConsultaAvaliacoesController@buscarAvaliacoes',
        '/cadastroAvaliacao' => 'CadastroAvaliacaoController@index',
        '/consultaPerguntas' => 'PerguntaController@exibirConsulta',
        '/consultaPerguntas/buscar' => 'PerguntaController@buscarPerguntas',
        '/pergunta/incluir' => 'PerguntaController@formularioIncluir'
    ],
    'POST' => [
        '/cadastroAvaliacao' => 'CadastroAvaliacaoController@registrarAvaliacao',
        '/pergunta/incluir' => 'PerguntaController@registrarPergunta'
    ]
];
