const chartEntreprise = document.getElementById('barCanvasEntreprise');

const data = {
    labels: ['Réponses envoyées', 'Candidatures consulté', 'Candidatures reçus'],
    datasets: [{
        label: 'stages',
        data: [30, 50, 70],
        backgroundColor: [
            'rgba(0, 102, 204, 0.7)',
            'rgba(255, 102, 102, 0.7)',
            'rgba(0, 204, 153, 0.7)'
        ],
        hoverBackgroundColor: [
            'rgba(0, 102, 204, 1)',
            'rgba(255, 102, 102, 1)',
            'rgba(0, 204, 153, 1)'
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

new Chart(chartEntreprise, {
    type: 'doughnut',
    data: data,
    options: options
});

document.querySelectorAll('.rating span').forEach(star => {
    star.addEventListener('click', function () {
        const rating = this.getAttribute('data-value');
        document.getElementById('rating-value').textContent = `Votre note : ${rating}/5`;

        document.querySelectorAll('.rating span').forEach(s => s.classList.remove('selected'));

        this.classList.add('selected');
        let nextSibling = this;
        while (nextSibling) {
            nextSibling.classList.add('selected');
            nextSibling = nextSibling.nextElementSibling;
        }
    });
});