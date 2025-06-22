<?php
$request = $_GET['action'] ?? ''; // Obtém a ação da URL

$routes = [
    '/' => 'HomeController@index',
    '/consultaAvaliacoes' => 'ConsultaAvaliacoesController@Index',
    '/consultaAvaliacoes/buscar' => 'ConsultaAvaliacoesController@BuscarAvaliacoes',
    '/cadastroAvaliacao' => 'CadastroAvaliacaoController@Index'
];
