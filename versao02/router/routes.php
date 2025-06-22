<?php

$routes = [
    'GET' => [
        '/' => 'HomeController@index',
        '/consultaAvaliacoes' => 'ConsultaAvaliacoesController@index',
        '/consultaAvaliacoes/buscar' => 'ConsultaAvaliacoesController@buscarAvaliacoes',
        '/cadastroAvaliacao' => 'CadastroAvaliacaoController@index'
    ],
    'POST' => [
        '/cadastroAvaliacao' => 'CadastroAvaliacaoController@registrarAvaliacao'
    ]
];
