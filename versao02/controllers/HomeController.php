<?php

class HomeController extends BaseController
{
    
    public function index(): void
    {
        $this->loadView('home.paginaInicial', []);
    }
}
