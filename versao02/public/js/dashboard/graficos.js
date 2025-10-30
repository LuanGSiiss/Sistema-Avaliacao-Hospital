
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