<?php

$routes = [
    'GET' => [
        '/' => 'HomeController@index',
        '/login' => 'LoginController@formularioLogin',
        '/consultaAvaliacoes' => 'ConsultaAvaliacoesController@exibirConsulta',
        '/consultaAvaliacoes/buscar' => 'ConsultaAvaliacoesController@buscarAvaliacoes',
        '/cadastroAvaliacao' => 'CadastroAvaliacaoController@index',
        '/consultaPerguntas' => 'PerguntaController@exibirConsulta',
        '/consultaPerguntas/buscar' => 'PerguntaController@buscarPerguntas',
        '/pergunta/incluir' => 'PerguntaController@formularioIncluir',
        '/pergunta/alterar/{id}' => 'PerguntaController@formularioAlterar',
        '/pergunta/visualizar/{id}' => 'PerguntaController@visualizarPergunta'
    ],
    'POST' => [
        '/login' => 'LoginController@validarLogin',
        '/cadastroAvaliacao' => 'CadastroAvaliacaoController@registrarAvaliacao',
        '/pergunta/incluir' => 'PerguntaController@registrarPergunta',
        '/pergunta/alterar/{id}' => 'PerguntaController@alterarPergunta'
    ],
    'DELETE' => [
        '/pergunta/excluir/{id}' => 'PerguntaController@excluirPergunta'
    ]
];
