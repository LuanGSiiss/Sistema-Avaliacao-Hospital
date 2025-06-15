<?php
$request = $_GET['action'] ?? ''; // Obtém a ação da URL

$routes = [
    '/' => 'HomeController@index',
    '/consultaAvaliacoes' => 'ConsultaAvaliacoesController@Index',
    '/consultaAvaliacoes/buscar' => 'ConsultaAvaliacoesController@BuscarAvaliacoes',
    '/cadastroAvaliacao' => 'CadastroAvaliacaoController@Index'
];



// switch ($request) {
//     case 'pag_consulta_avaliacoes':
//         require '../controller/controller_define_setor.php';
//         break;
//     case 'consulta_avaliacoes':
//         require '../controller/controller_consulta.php';
//         break; 
//     case 'login':
//         require '../controller/controller_login.php';
//         break;
//     case 'busca_setores':
//         require '../controller/controller_homeSelecao.php';
//         break;
//     default:
//         echo json_encode(['erro' => 'Rota não encontrada']);
// }
