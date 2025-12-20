<?php

class RenderView
{
    public function loadView($caminhoview, $args):void
    {
        try {
            if (strpos($caminhoview, '.') === false) {
                throw new Exception("Formato de caminho de view inválido. Use 'pasta.view'.");
            }

            [$pasta, $view] = explode('.', $caminhoview);
            $caminhoCompleto = __DIR__ . "/../views/$pasta/$view.php";

            if (!file_exists($caminhoCompleto)) {
                throw new Exception("Arquivo da view não encontrado: $caminhoCompleto");
            }

            extract($args);
            require_once $caminhoCompleto;

        } catch (Throwable $e) {
            http_response_code(500);

            echo json_encode([
                'status' => 'erro',
                'message' => 'Erro ao carregar a página: ' . $e
            ], JSON_UNESCAPED_UNICODE);
        }
    }
}