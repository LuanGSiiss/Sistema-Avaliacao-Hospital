<?php

class HomeController extends RenderView
{
    public function index()
    {
        $users = new Exemplo();

        $this->loadView('home', [
            'title' => 'Home Page',
            'teste' => $users->fetch()
        ]); 
    }
}