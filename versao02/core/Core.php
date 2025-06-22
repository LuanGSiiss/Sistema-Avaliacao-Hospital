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
                $pattern = '#^' . $path . '$#';
                if (preg_match($pattern, $url)) {
                    $routerFound = true;

                    [$currentController, $action] = explode('@', $controller);
                    require_once __DIR__ . "/../controllers/$currentController.php";

                    $newController = new $currentController();
                    $newController->$action();
                    return;
                }
            }
        }

        if(!$routerFound) {
            require_once __DIR__."/../controllers/NotFoundController.php";
            $controller = new NotFoundController();
            $controller->index();
        }
    }
}