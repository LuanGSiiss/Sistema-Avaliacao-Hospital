<?php

class NotFoundController
{
    public function index($mensagemErro)
    {
        if ($mensagemErro) {
            echo $mensagemErro;
        } else {
            echo "Not Found";
        }
    }
}