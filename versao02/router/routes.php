<?php

$routes = [
    'GET' => [
        '/login' => 'LoginController@formularioLogin@semSessao',
        '/consultaAvaliacoes' => 'ConsultaAvaliacoesController@exibirConsulta@comSessao',
        '/consultaAvaliacoes/buscar' => 'ConsultaAvaliacoesController@buscarAvaliacoes@comSessao',
        '/cadastroAvaliacao' => 'CadastroAvaliacaoController@index@comSessao',
        '/consultaPerguntas' => 'PerguntaController@exibirConsulta@comSessao',
        '/consultaPerguntas/buscar' => 'PerguntaController@buscarPerguntas@comSessao',
        '/pergunta/incluir' => 'PerguntaController@formularioIncluir@comSessao',
        '/pergunta/alterar/{id}' => 'PerguntaController@formularioAlterar@comSessao',
        '/pergunta/visualizar/{id}' => 'PerguntaController@visualizarPergunta@comSessao'
    ],
    'POST' => [
        '/login' => 'LoginController@validarLogin@semSessao',
        '/cadastroAvaliacao' => 'CadastroAvaliacaoController@registrarAvaliacao@comSessao',
        '/pergunta/incluir' => 'PerguntaController@registrarPergunta@comSessao',
        '/pergunta/alterar/{id}' => 'PerguntaController@alterarPergunta@comSessao'
    ],
    'DELETE' => [
        '/pergunta/excluir/{id}' => 'PerguntaController@excluirPergunta@comSessao'
    ]
];
