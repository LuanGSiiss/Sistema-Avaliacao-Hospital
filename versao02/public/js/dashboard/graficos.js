var graficoMediasNotasPorSetor = null;
var graficoProporcaoAvaliacoesPorSetor = null;
var graficoMediasNotasUltimosMeses = null;


export async function carregarGraficos(indicadores) {

  carregarGraficoMediasNotasUltimosMeses(indicadores.mediasNotasUltimosMeses)
  carregarGraficoMediasNotasPorSetor(indicadores.mediasNotasPorSetor);
  carregarGraficoProporcaoAvaliacoesPorSetor(indicadores.proporcaoAvaliacoesPorSetor);
};

//funções "filhas"
async function carregarGraficoMediasNotasUltimosMeses(dados) {
  if (graficoMediasNotasUltimosMeses) {
    graficoMediasNotasUltimosMeses.destroy();
  }

  graficoMediasNotasUltimosMeses = new Chart(
    document.getElementById('mediasNotasUltimosMeses'),
    {
      type: 'bar',
      options: {
        scales: {
          y: {
            max: 10,
            min: 1
          }
        }
      },
      data: {
        labels: dados.map(x => x.mes),
        datasets: [
          {
            label: 'Média das Avaliações dos últimos 12 meses',
            data: dados.map(row => row.media)
          }
        ]
      }
    }
  );
};

async function carregarGraficoMediasNotasPorSetor(dados) {
  if (graficoMediasNotasPorSetor) {
    graficoMediasNotasPorSetor.destroy();
  }

  graficoMediasNotasPorSetor = new Chart(
    document.getElementById('mediasNotasPorSetor'),
    {
      type: 'bar',
      options: {
        scales: {
          y: {
            max: 10,
            min: 1
          }
        }
      },
      data: {
        labels: dados.map(x => x.setor),
        datasets: [
          {
            label: 'Média das Avaliações por Setor',
            data: dados.map(row => row.media)
          }
        ]
      }
    }
  );
};

async function carregarGraficoProporcaoAvaliacoesPorSetor(dados) {
  if (graficoProporcaoAvaliacoesPorSetor) {
    graficoProporcaoAvaliacoesPorSetor.destroy();
  }

  graficoProporcaoAvaliacoesPorSetor = new Chart(
    document.getElementById('proporcaoAvaliacoesPorSetor'),
    {
      type: 'pie',
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
          },
          title: {
            display: true,
            text: 'Proporção da quantidade de avaliações por setor'
          }
        }
      },
      data: {
        labels: dados.map(x => x.setor),
        datasets: [
          {
            label: 'Quantidade de avaliações',
            data: dados.map(row => row.total)
          }
        ]
      }
    }
  );
};

