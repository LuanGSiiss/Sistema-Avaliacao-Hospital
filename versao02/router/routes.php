<?php

$routes = [
    'GET' => [
        '/' => 'HomeController@index@comSessao',
        
        '/login' => 'LoginController@formularioLogin@semSessao',

        '/consultaAvaliacoes' => 'AvaliacaoController@exibirConsulta@comSessao',
        '/consultaAvaliacoes/buscar' => 'AvaliacaoController@buscarAvaliacoes@comSessao',
        '/cadastroAvaliacao' => 'AvaliacaoController@formularioAvaliacao@semSessao',

        '/consultaPerguntas' => 'PerguntaController@exibirConsulta@comSessao',
        '/consultaPerguntas/buscar' => 'PerguntaController@buscarPerguntas@comSessao',
        '/pergunta/incluir' => 'PerguntaController@formularioIncluir@comSessao',
        '/pergunta/alterar/{id}' => 'PerguntaController@formularioAlterar@comSessao',
        '/pergunta/visualizar/{id}' => 'PerguntaController@visualizarPergunta@comSessao',

        '/consultaSetores' => 'SetorController@exibirConsulta@comSessao',
        '/consultaSetores/buscar' => 'SetorController@buscarSetores@comSessao',
        '/setor/incluir' => 'SetorController@formularioIncluir@comSessao',
        '/setor/alterar/{id}' => 'SetorController@formularioAlterar@comSessao',
        '/setor/visualizar/{id}' => 'SetorController@visualizarSetor@comSessao',

        '/consultaDispositivos' => 'DispositivoController@exibirConsulta@comSessao',
        '/consultaDispositivos/buscar' => 'DispositivoController@buscarDispositivos@comSessao',
        '/dispositivo/incluir' => 'DispositivoController@formularioIncluir@comSessao',
        '/dispositivo/alterar/{id}' => 'DispositivoController@formularioAlterar@comSessao',
        '/dispositivo/visualizar/{id}' => 'DispositivoController@visualizarDispositivo@comSessao',

        '/dashboard' => 'DashboardController@exibirPainel@comSessao',
        '/dashboard/buscar' => 'DashboardController@buscarIndicadores@comSessao',
    ],
    'POST' => [
        '/login' => 'LoginController@validarLogin@semSessao',

        '/avaliacao/incluir' => 'AvaliacaoController@registrarAvaliacao@semSessao',

        '/pergunta/incluir' => 'PerguntaController@registrarPergunta@comSessao',
        '/pergunta/alterar/{id}' => 'PerguntaController@alterarPergunta@comSessao',

        '/setor/incluir' => 'SetorController@registrarSetor@comSessao',
        '/setor/alterar/{id}' => 'SetorController@alterarSetor@comSessao',

        '/dispositivo/incluir' => 'DispositivoController@registrarDispositivo@comSessao',
        '/dispositivo/alterar/{id}' => 'DispositivoController@alterarDispositivo@comSessao'
    ],
    'DELETE' => [
        '/pergunta/excluir/{id}' => 'PerguntaController@excluirPergunta@comSessao',

        '/setor/excluir/{id}' => 'SetorController@excluirSetor@comSessao',

        '/dispositivo/excluir/{id}' => 'DispositivoController@excluirDispositivo@comSessao'
    ]
];
