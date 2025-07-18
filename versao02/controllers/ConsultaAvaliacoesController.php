<?php

class ConsultaAvaliacoesController extends RenderView
{
    public function exibirConsulta()
    {
        $this->loadView('avaliacao.consultaAvaliacoes', []); 
    }

    public function BuscarAvaliacoes()
    {
        $model = new AvaliacaoModel();
        
        try {
            $avaliacoesBase = $model->BuscarTodas();
            
            $arrayAvaliacoes = array_map(function ($registro) {
                return [
                    'id_avaliacao'      => $registro['id_avaliacao'], 
                    'id_setor'          => $registro['id_setor'], 
                    'id_pergunta'       => $registro['id_pergunta'], 
                    'id_dispositivo'    => $registro['id_dispositivo'], 
                    'nota'          => $registro['nota'], 
                    'feedback_textual'  => $registro['feedback_textual'], 
                    'datahora_cadastro' => date('d/m/Y H:i:s', strtotime($registro['datahora_cadastro']))
                ];
            }, $avaliacoesBase);
            
            echo json_encode([
                'status' => 'sucesso',
                'data' => [
                    'avaliacoes' => $arrayAvaliacoes
                ] 
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'erro',
                'message' => $e->getMessage() 
            ]);
        }
    }
}