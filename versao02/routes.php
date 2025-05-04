<?php
// $request = $_GET['action'] ?? ''; // Obtém a ação da URL
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

// 1. Captura o caminho da URL, ignorando parâmetros como ?id=5
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// 2. Captura o método HTTP (GET, POST, PUT, DELETE, etc.)
$method = $_SERVER['REQUEST_METHOD'];

// 3. (Opcional) Remove prefixo de pasta caso você esteja usando subdiretórios
$base = 'Luang/Sistema_Avaliacao_Hospital/versao02/public'; // ajuste conforme sua pasta
if (strpos($uri, $base) === 0) {
    $uri = substr($uri, strlen($base));
}

// 4. Junta método + rota para facilitar o uso no switch
$routeKey = "$method $uri";

// 5. Define o que acontece para cada rota
switch ($routeKey) {
    case 'GET ConsultaAvaliacoes':
        require 'view/administrativoConsulta.php';
        break;

    case 'POST login':
        // Exemplo: /login via POST → processar login
        require 'controller/LoginController.php';
        break;

    case 'GET login':
        // Exibe o formulário de login (view)
        require 'view/login.php';
        break;

    case 'GET pagina-avaliacao':
        // Exibe página HTML com avaliações (sem lógica)
        require 'view/paginaAvaliacao.php';
        break;

    default:
        // Rota não encontrada
        http_response_code(404);
        echo 'Página não encontrada.';
        break;
}

?>

