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
            'mediasNotasUltimosMeses'     => $this->buscarMediasNotasUltimosMeses(),
            'mediasNotasPorPergunta'      => $this->buscarMediasNotasPorPergunta()
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

        $map = [];
        foreach ($resultado as $registro) {
            $chave = (new DateTime($registro['mes']))->format('Y-m');
            $map[$chave] = $registro['media'];
        }

        $mesAtual = new DateTime("first day of this month", new DateTimeZone("America/Sao_Paulo"));
        $saida = [];

        for ($i = 0; $i < 12; $i++) {
            $mesTemporario = (clone $mesAtual)->modify("-$i months");
            $chave = $mesTemporario->format('Y-m');

            $saida[] = [
                'mes' => $mesTemporario->format('m/Y'),
                'media' => $map[$chave] ?? 0
            ];
        }

        return array_reverse($saida);
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
        $sqlBusca = "SELECT setores.descricao as setor, count(avaliacoes.id_setor) as total from avaliacoes
                        RIGHT JOIN setores 
                        ON setores.id_setor = avaliacoes.id_setor
                        GROUP BY setores.descricao
                        ORDER BY total DESC;";
        $stmt = $this->pdo->prepare($sqlBusca);
        $stmt->execute([]);
        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    public function buscarMediasNotasPorPergunta(): array
    {
        $sqlBusca = "SELECT perguntas.id_pergunta, perguntas.texto_pergunta, avg(avaliacoes.nota) as media from avaliacoes
                        RIGHT JOIN perguntas 
                        ON perguntas.id_pergunta = avaliacoes.id_pergunta
                        GROUP BY perguntas.id_pergunta
                        ORDER BY perguntas.id_pergunta;";
        $stmt = $this->pdo->prepare($sqlBusca);
        $stmt->execute([]);
        $resultado = $stmt->fetchAll();

        return $resultado;
    }
}