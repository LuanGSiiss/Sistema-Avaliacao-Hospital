<?php

class RenderView
{
    public function loadView($caminhoview, $args) 
    {
        try {
            if (strpos($caminhoview, '.') === false) {
                throw new InvalidArgumentException("Formato de caminho de view inválido. Use 'pasta.view'.");
            }

            [$pasta, $view] = explode('.', $caminhoview);
            $caminhoCompleto = __DIR__ . "/../views/$pasta/$view.php";

            if (!file_exists($caminhoCompleto)) {
                throw new RuntimeException("Arquivo da view não encontrado: $caminhoCompleto");
            }

            extract($args);
            require_once $caminhoCompleto;

        } catch (Throwable $e) {
            http_response_code(500);

            echo json_encode([
                'status' => 'erro',
                'message' => 'Erro ao carregar a página.'
            ]);
        }
    }
}