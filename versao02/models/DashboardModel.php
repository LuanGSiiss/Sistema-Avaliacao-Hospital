<?php

class DashboardModel extends Database
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->getConnection();
        
        if (!$this->pdo) {
            throw new Exception("Erro ao conectar com o banco de dados.");
        }
    }

    // [
    //     [id_setor => 2, media =>7]
    // ]
    public function buscarMediasNotasPorSetor(): array
    {
        $sqlBusca = "SELECT id_setor, avg(nota) from avaliacoes
                    GROUP BY id_setor
                    ORDER BY id_setor;";
        $stmt = $this->pdo->prepare($sqlBusca);
        $stmt->execute([]);
        $resultado = $stmt->fetchAll();

        // tratar para levar o nome e não o id do setor
        if(!class_exists('SetorModel')) {
            throw new Exception("Classe 'SetorModel' não existe.");
        }

        $setorModel = new SetorModel();
        $setoresBase = $setorModel->BuscarTodas();

        $mapaSetores = array_column($setoresBase, 'descricao', 'id_setor');

        $resultadoTratado = array_map(function ($registro) use ($mapaSetores) {
            return [
                'setor' => $mapaSetores[$registro['id_setor']] ?? null,
                'nota'  => $registro['nota']    
            
            ];
        }, $resultado);

        return $resultado;
    }

}