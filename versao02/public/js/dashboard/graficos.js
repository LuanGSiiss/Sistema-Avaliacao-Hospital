var graficoMediasNotasPorSetor = null;
var graficoProporcaoAvaliacoesPorSetor = null;
var graficoMediasNotasUltimosMeses = null;

const cores = {
    primaria: '#0ea5e9', 
    secundaria: '#4f46e5'
};

async function carregarGraficos(indicadores) {
  Chart.defaults.font.family = "'Segoe UI', sans-serif";

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
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { 
            display: false 
          }, 
          tooltip: {
            backgroundColor: '#1f2937',
            padding: 12,
            cornerRadius: 8,
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            max: 10
          }
        }
      },
      data: {
        labels: dados.map(x => x.mes),
        datasets: [
          {
            label: 'Média Mensal',
            data: dados.map(row => row.media),
            backgroundColor: cores.primaria,
            borderRadius: 6,
            barPercentage: 0.8
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
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { 
            display: false 
          }
        },
        scales: {
          y: {
            grid: { 
              display: false 
            }
          },
          x: {
            max: 10
          }
        }
      },
      data: {
        labels: dados.map(x => x.setor),
        datasets: [
          {
            label: 'Nota Média',
            data: dados.map(row => row.media),
            backgroundColor: cores.secundaria,
            borderRadius: 4,
            barThickness: 40,
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
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
            labels: { 
              usePointStyle: true, 
              padding: 20 
            }
          },
          title: {
            display: false
          }
        }
      },
      data: {
        labels: dados.map(x => x.setor),
        datasets: [
          {
            data: dados.map(row => row.total),
            borderWidth: 0,
            hoverOffset: 10
          }
        ]
      }
    }
  );
};

