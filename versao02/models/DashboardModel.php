<?php

class DashboardModel extends Database
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->getConnection();
    }

    public function buscarIndicadores():array
    {
        $indicadores = [
            'mediasNotasPorSetor'         => $this->buscarMediasNotasPorSetor(),
            'proporcaoAvaliacoesPorSetor' => $this->buscarProporcaoAvaliacoesPorSetor(),
            'mediasNotasUltimosMeses'     => $this->buscarMediasNotasUltimosMeses(),
            'mediasNotasPorPergunta'      => $this->buscarMediasNotasPorPergunta()
        ];

        return $indicadores;
    }

    // Retorna a média das notas de todas a avaliações dos últimos 12 meses agrupadas pelo mês
    public function buscarMediasNotasUltimosMeses():array
    {
        $sqlBusca = "SELECT DATE_TRUNC('month', datahora_cadastro) AS mes, avg(nota) AS media 
                        FROM avaliacoes
                        GROUP BY mes
                        ORDER BY mes DESC;";
        $stmt = $this->pdo->prepare($sqlBusca);
        $stmt->execute([]);
        $resultado = $stmt->fetchAll();

        $arrayMontado = $this->montarArrayUltimosDozeMeses($resultado);

        return $arrayMontado;
    }

    // Retorna a média das notas de cada setor
    public function buscarMediasNotasPorSetor():array
    {
        $sqlBusca = "SELECT setores.descricao AS setor, avg(nota) AS media 
                        FROM avaliacoes
                        RIGHT JOIN setores 
                            ON setores.id_setor = avaliacoes.id_setor
                        GROUP BY setores.descricao
                        ORDER BY media DESC;";
        $stmt = $this->pdo->prepare($sqlBusca);
        $stmt->execute([]);
        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    // Retorna a quantidade de avaliações de cada setor
    public function buscarProporcaoAvaliacoesPorSetor():array
    {
        $sqlBusca = "SELECT setores.descricao AS setor, count(avaliacoes.id_setor) AS total 
                        FROM avaliacoes
                        RIGHT JOIN setores 
                            ON setores.id_setor = avaliacoes.id_setor
                        GROUP BY setores.descricao
                        ORDER BY total DESC;";
        $stmt = $this->pdo->prepare($sqlBusca);
        $stmt->execute([]);
        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    // Retorna a média das notas de cada pergunta
    public function buscarMediasNotasPorPergunta():array
    {
        $sqlBusca = "SELECT perguntas.id_pergunta, perguntas.texto_pergunta, avg(avaliacoes.nota) AS media 
                        FROM avaliacoes
                        RIGHT JOIN perguntas 
                            ON perguntas.id_pergunta = avaliacoes.id_pergunta
                        GROUP BY perguntas.id_pergunta
                        ORDER BY perguntas.id_pergunta;";
        $stmt = $this->pdo->prepare($sqlBusca);
        $stmt->execute([]);
        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    // Usado para montar um array com os últimos doze meses, desta forma garantido que será retornado um array de 12 meses, independente se houveram avaliações nestes meses
    private function montarArrayUltimosDozeMeses(array $resultadoQuery):array
    {
        $map = [];
        foreach ($resultadoQuery as $registro) {
            $chave = (new DateTime($registro['mes']))->format('Y-m');
            $map[$chave] = $registro['media'];
        }

        $mesAtual = new DateTime("first day of this month", new DateTimeZone("America/Sao_Paulo"));
        $saida = [];

        for ($i = 0; $i < 12; $i++) {
            $mesTemporario = (clone $mesAtual)->modify("-$i months");
            $chave = $mesTemporario->format('Y-m');

            $saida[] = [
                'mes'   => $mesTemporario->format('m/Y'),
                'media' => $map[$chave] ?? 0
            ];
        }

        return array_reverse($saida);
    }
}