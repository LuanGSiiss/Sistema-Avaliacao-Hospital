var graficoMediasNotaPorSetor = null;
var graficoProporcaoAvaliacoesPorSetor = null;


export async function carregarGraficos(indicadores) {

  carregarGraficoMediasNotaPorSetor(indicadores.mediasNotasPorSetor);
};


async function carregarGraficoMediasNotaPorSetor(dados) {
  if (graficoMediasNotaPorSetor) {
    graficoMediasNotaPorSetor.destroy();
  }

  graficoMediasNotaPorSetor = new Chart(
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
            label: 'Média de Notas por Setor',
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
            text: 'Proporção do número de avaliações por setor'
          }
        }
      },
      data: {
        labels: ['Red', 'Orange', 'Yellow', 'Green', 'Blue'],
        datasets: [
          {
            label: 'Média de Notas por Setor',
            data: dados.map(row => row.media)
          }
        ]
      }
    }
  );
};

