<?php

class RenderView
{
    public function loadView($caminhoview, $args) 
    {
        [$pasta, $view] = explode('.', $caminhoview);
        extract($args);

        require_once __DIR__."/../views/$pasta/$view.php";
    }
}