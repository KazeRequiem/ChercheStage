(() => {
    const chartCandidat = document.getElementById('barCanvasCandidat');

    if (chartCandidat) {
        const data = {
            labels: ['CV envoyés', 'Réponses reçues', 'Entretiens obtenus'],
            datasets: [{
                label: 'Candidats',
                data: [50, 30, 20],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)'
                ],
                hoverBackgroundColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 2
            }]
        };

        const options = {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { 
                        font: { 
                            size: 14 
                        } 
                    }
                },
                tooltip: { enabled: true }
            },
            cutout: '70%'
        };

        new Chart(chartCandidat, { type: 'doughnut', data, options });
    }
})();
