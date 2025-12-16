<?php

class DashboardController extends BaseController
{
    public function exibirPainel():void
    {
        $this->loadView('dashboard.painel', []);
    }

    public function buscarIndicadores():void
    {
        try {
            $dashboardModel = new DashboardModel();
            $indicadores = $dashboardModel->buscarIndicadores();

            $this->tratarSucessoRetornoJson([
                'indicadores' => $indicadores
            ]);
        }  catch (Throwable $e) {
            $this->tratarErroRetornoJson($e);
        }
    }
}
