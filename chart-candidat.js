const chartCandidat = document.getElementById('barCanvasCandidat');

const data = {
    labels: ['Réponses reçues', 'Nombre de vues', 'CV envoyés'],
    datasets: [{
        label: 'Stages',
        data: [30, 50, 70],
        backgroundColor: [
            'rgba(75, 192, 192, 0.7)',
            'rgba(255, 159, 64, 0.7)',
            'rgba(54, 162, 235, 0.7)'
        ],
        hoverBackgroundColor: [
            'rgba(75, 192, 192, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(54, 162, 235, 1)'
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
        tooltip: {
            enabled: true
        }
    },
    cutout: '70%'
};

new Chart(chartCandidat, {
    type: 'doughnut',
    data: data,
    options: options
});