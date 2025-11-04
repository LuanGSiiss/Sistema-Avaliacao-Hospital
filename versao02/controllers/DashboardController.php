<?php

class DashboardController extends RenderView
{
    public function exibirPainel()
    {
        $this->loadView('dashboard.painel', []);
    }

    public function buscarIndicadores()
    {
        try {
            if(!class_exists('DashboardModel')) {
                throw new Exception("Classe 'DashboardModel' não existe.");
            }
            
            $dashboardModel = new DashboardModel();
            $indicadores = $dashboardModel->buscarIndicadores();
            
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(200);
            echo json_encode([
                'status' => 'sucesso',
                'data' => [
                    'indicadores' => $indicadores
                ] 
            ], JSON_UNESCAPED_UNICODE);
        }  catch (Throwable $e) {
            $this->tratarErroRetornoJson($e);
        }
    }

    private function tratarErroRetornoJson(Throwable $e) {
        $httpCode = 500;
        $mensagem = "Erro inesperado ao tratar a requisição";
        
        if ($e instanceof PDOException) {
            $mensagem = "Erro de banco de dados: " . $e->getMessage();
        } elseif($e instanceof Exception) {
            $httpCode = 400;
            $mensagem = "Ocorreu um erro inesperado: " . $e->getMessage();
        } elseif($e instanceof Error) {
            $mensagem = "Erro fatal: " . $e->getMessage();
        }

        if (!mb_check_encoding($mensagem, 'UTF-8')) {
            $mensagem = mb_convert_encoding($mensagem, 'UTF-8', 'auto');
        }

        header('Content-Type: application/json; charset=utf-8');
        http_response_code($httpCode);
        echo json_encode([
            'status' => 'erro',
            'message' => $mensagem
        ], JSON_UNESCAPED_UNICODE);
    }
}
