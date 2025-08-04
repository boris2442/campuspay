 window.onload = function () {
        const niveauCtx = document.getElementById('niveauChart').getContext('2d');


    new Chart(niveauCtx, {
    type: 'pie',
    data: {
        labels: @json($niveauLabels),
        datasets: [{
            label: "Nombre d'étudiants",
            data: @json($niveauCounts),
            backgroundColor: [
                '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#00C49F', '#FF9F40'
            ],
            borderColor: '#fff',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Répartition des étudiants par niveau',
                font: {
                    size: 18
                },
                color: '#222',
                padding: {
                    top: 10,
                    bottom: 20
                }
            },
            legend: {
                position: 'bottom',
                labels: {
                    font: {
                        size: 14
                    },
                    color: '#333'
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const label = context.label || '';
                        const value = context.raw || 0;
                        return `${label} : ${value} étudiant(s)`;
                    }
                }
            },
            datalabels: {
                color: '#fff',
                formatter: (value, ctx) => {
                    const total = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                    const percent = (value / total * 100).toFixed(1);
                    return `${percent}%`;
                },
                font: {
                    weight: 'bold'
                }
            }
        },
        animation: {
            animateRotate: true,
            duration: 1000,
            easing: 'easeOutBounce'
        }
    },
    plugins: [ChartDataLabels] // 👈 très important pour activer les % sur le graphe
});

 }