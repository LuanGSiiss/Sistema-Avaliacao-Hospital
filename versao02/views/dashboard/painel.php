<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- links do menu -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/layout/menu-styles.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/dashboard/painel.css">
    <script src="<?= BASE_URL ?>public/js/dashboard/comportamento_painel.js" defer></script>
    <!-- charjs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <!-- Menu -->
    <?php require_once __DIR__ .  '/../layout/menu.php'; ?>

    <button id="butaoConsulta">Consultar</button>
    <!-- Média das notas por setor -->
    <div style="width: 800px;"><canvas id="mediaNotaPorSetor"></canvas></div>

    <!-- <script type="module" src="<?= BASE_URL ?>public/js/dashboard/graficos.js"></script> -->

<script>
document.getElementById("butaoConsulta").addEventListener("click", function () {

    const func_assinc = new XMLHttpRequest();
    func_assinc.open("GET", "./dashboard/buscar", true);
    func_assinc.onload = function () {
        if (func_assinc.status === 200) {
            try {
                const dadosResposta = JSON.parse(func_assinc.responseText);
                
                if (dadosResposta.status === 'sucesso') {
    
                    const conteudo = dadosResposta.data;
    
                    if (!conteudo) {
                        console.log("Nenhum registro encontrado");
                    } else {
                        carregarGraficos(conteudo.mediasNotasPorSetor);
                    }
                } else {
                    exibirMensagemRetorno('Erro com os dados da requisição.', 0);
                    console.log(dadosResposta.message);
                }
            } catch (erro) {
                exibirMensagemRetorno('Erro ao tratar os dados da requisição.', 0);
                console.error("Erro ao tratar os dados da requisição: ", erro.message);
            }
        } else if(func_assinc.status === 400 || func_assinc.status === 500) {
            var dadosResposta;
            try {
                dadosResposta = JSON.parse(func_assinc.responseText).message;
                
            } catch {
                dadosResposta = func_assinc.responseText;
            }
            exibirMensagemRetorno(dadosResposta, 0);
            console.error(dadosResposta);
        } else {
            alert("requisição invalida");
        }
    };
    
    func_assinc.send();
});

(async function carregarGraficos(dados) {
  
  new Chart(
    document.getElementById('mediaNotaPorSetor'),
    {
      type: 'bar',
      data: {
        labels: dados.map(x => x.setor),
        datasets: [
          {
            label: 'Média de Notas por Setor',
            data: dados.map(row => row.media)
          }
        ]
      }
    }
  );
})();
</script>
</body>
</html>