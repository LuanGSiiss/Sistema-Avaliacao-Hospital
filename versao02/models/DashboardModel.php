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

    public function buscarIndicadores(): array
    {
        $indicadores = [
            'mediasNotasPorSetor'         => $this->buscarMediasNotasPorSetor(),
            'proporcaoAvaliacoesPorSetor' => $this->buscarProporcaoAvaliacoesPorSetor(),
            'mediasNotasUltimosMeses'     => $this->buscarMediasNotasUltimosMeses()
        ];

        return $indicadores;
    }

    public function buscarMediasNotasUltimosMeses(): array
    {
        $sqlBusca = "SELECT DATE_TRUNC('month', datahora_cadastro) as mes, avg(nota) as media from avaliacoes
                        GROUP BY mes
                        ORDER BY mes desc;";
        $stmt = $this->pdo->prepare($sqlBusca);
        $stmt->execute([]);
        $resultado = $stmt->fetchAll();

        $mesAtual = new DateTime("first day of this month", new DateTimeZone("America/Sao_Paulo"));

        $resultadoComDozeMeses = [];
        if(count($resultado) < 12) {
            for ($i = 12; $i >= 1; $i--) {
                if(isset($resultado[$i])) {
                    $resultadoComDozeMeses[$i] = $resultado[$i];
                } else {
                    $mesAtualTemporario = clone $mesAtual;
                    $dataMesIteracao = $mesAtualTemporario->modify("-12 months");
                    $resultadoComDozeMeses[$i]['mes'] = $dataMesIteracao->format("y-m-d h:m:s");
                    $resultadoComDozeMeses[$i]['media'] = 0;
                }
            }
        } else {
            $resultadoComDozeMeses = $resultado;
        }

        $resultadoComDozeMeses = array_values($resultadoComDozeMeses);

        return $resultadoComDozeMeses;
    }

    public function buscarMediasNotasPorSetor(): array
    {
        $sqlBusca = "SELECT id_setor, avg(nota) as media from avaliacoes
                    GROUP BY id_setor
                    ORDER BY id_setor;";
        $stmt = $this->pdo->prepare($sqlBusca);
        $stmt->execute([]);
        $resultado = $stmt->fetchAll();

        if(!class_exists('SetorModel')) {
            throw new Exception("Classe 'SetorModel' não existe.");
        }

        $setorModel = new SetorModel();
        $setoresBase = $setorModel->BuscarTodas();

        $mapaSetores = array_column($setoresBase, 'descricao', 'id_setor');

        // tratar para levar o nome e não o id do setor
        $resultadoTratado = array_map(function ($registro) use ($mapaSetores) {
            return [
                'setor' => $mapaSetores[$registro['id_setor']] ?? null,
                'media'  => $registro['media']    
            
            ];
        }, $resultado);

        return $resultadoTratado;
    }

    public function buscarProporcaoAvaliacoesPorSetor(): array
    {
        $sqlBusca = "SELECT id_setor, count(id_setor) as total from avaliacoes
                    GROUP BY id_setor
                    ORDER BY id_setor;";
        $stmt = $this->pdo->prepare($sqlBusca);
        $stmt->execute([]);
        $resultado = $stmt->fetchAll();

        if(!class_exists('SetorModel')) {
            throw new Exception("Classe 'SetorModel' não existe.");
        }

        $setorModel = new SetorModel();
        $setoresBase = $setorModel->BuscarTodas();

        $mapaSetores = array_column($setoresBase, 'descricao', 'id_setor');

        // tratar para levar o nome e não o id do setor
        $resultadoTratado = array_map(function ($registro) use ($mapaSetores) {
            return [
                'setor' => $mapaSetores[$registro['id_setor']] ?? null,
                'totalAvaliacoes'  => $registro['total']    
            
            ];
        }, $resultado);

        return $resultadoTratado;
    }
}