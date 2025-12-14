<?php

class BaseController extends RenderView
{
    protected function tratarErroRetornoJson(Throwable $e):void
    {
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

    protected function tratarSucessoRetornoJson(array $conteudo, int $httpCode = 200):void
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($httpCode);
        echo json_encode([
            'status' => 'sucesso',
            'data' => $conteudo 
        ], JSON_UNESCAPED_UNICODE);
    }
}
