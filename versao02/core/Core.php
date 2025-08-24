<?php

class Core 
{
    public function run($routes) 
    {
        $url = '/';
        $method = $_SERVER['REQUEST_METHOD'];

        $url .= isset($_GET['url']) ? $_GET['url'] : '';
        $url = rtrim($url, '/');

        $routerFound = false;

        if (isset($routes[$method])) {
            foreach ($routes[$method] as $path => $controller) {
                $pattern = '#^' . preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([a-zA-Z0-9_.-]+)', $path) . '$#';

                if (preg_match($pattern, $url, $matches)) {
                    $routerFound = true;
                    array_shift($matches);

                    [$currentController, $action, $withSession] = explode('@', $controller);
                    
                    //Vericar se é necessário estar logado para acessar a página
                    if ($withSession === "comSessao") {
                        SessaoModel::validarSessao();
                    }

                    $controllerFilePath = __DIR__ . "/../controllers/$currentController.php";
                    if (!file_exists($controllerFilePath)) {
                        $this->tratarNotFound("Arquivo do controller não encontrado: $controllerFilePath");
                        return;
                    }

                    require_once $controllerFilePath;
                    $newController = new $currentController();

                    if (!method_exists($newController, $action)) {
                        $this->tratarNotFound("Método não encontrado: $action");
                        return;
                    }

                    try {
                        call_user_func_array([$newController, $action], $matches);
                    } catch(Exception $e) {
                        $this->tratarErroMetodoClasse( $e->getMessage() );
                    }

                    return;
                }
            }
        }

        if(!$routerFound) {
            $this->tratarNotFound();
        }
    }

    private function tratarNotFound(string $mensagemErro = '') 
    {
        require_once __DIR__."/../controllers/NotFoundController.php";
        $controller = new NotFoundController();
        $controller->index($mensagemErro);
    }

    private function tratarErroMetodoClasse(string $mensagemErro = '') 
    {
        echo "Erro inesperado na chamado do método: " . $mensagemErro;
    }
}