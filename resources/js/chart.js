const lineCtx = document.getElementById('lineChart').getContext('2d');

const daysInMonth = 31;
const lineLabels = Array.from({ length: daysInMonth }, (_, i) => i + 1);

// lahat ng days = null (walang data)
const lineValues = new Array(daysInMonth).fill(null);

// put value on days index + 1 = day just example
lineValues[2] = 4;
lineValues[3] = 40;
lineValues[4] = 42;

const initialValues = lineValues.map(v => v !== null ? 0 : null);

const lineChart = new Chart(lineCtx, {
    type: 'line',
    data: {
        labels: lineLabels,
        datasets: [{
            label: 'Budget:',
            data: initialValues,
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59,130,246,0.15)',
            borderWidth: 2,
            tension: 0,
            fill: false,
            spanGaps: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: {
            duration: 1600,
            easing: 'easeOutQuart'
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Days',
                    font: {
                        size: 14,
                        weight: 'bold'
                    }
                }
            },
            y: {
                beginAtZero: true,
                min: 0,
                title: {
                    display: true,
                    text: 'Budget (in thousands)',
                    font: {
                        size: 14,
                        weight: 'bold'
                    }
                },
                ticks: {
                    callback: function(value) {
                        return value + 'k';
                    }
                }
            }
        },
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    title: function (context) {
                        const day = context[0].dataIndex + 1;
                        return `Day ${day}`;
                    },
                    label: function (context) {
                        return `${context.dataset.label} ${context.parsed.y}k`;
                    }
                }
            }
        }
    }
});

setTimeout(() => {
    lineChart.data.datasets[0].data = lineValues;
    lineChart.update();
}, 300);



const donutCtx = document.getElementById('donutChart').getContext('2d');

const donutLabels = ['Clothing', 'Food Products', 'Electronics', 'Kitchen Utility', 'Gardening'];
const donutValues = [30, 20, 25, 15, 10];

const donutChart = new Chart(donutCtx, {
    type: 'doughnut',
    data: {
        labels: donutLabels,
        datasets: [{
            data: new Array(donutValues.length).fill(0),
            backgroundColor: ['#4fd1c5', '#60a5fa', '#facc15', '#f87171', '#a78bfa'],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '70%',
        animation: {
            duration: 1600,
            easing: 'easeOutQuart'
        },
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                callbacks: {
                    label: (context) => `${context.label}: ${context.parsed}%`
                }
            },
            datalabels: {
                color: '#111',
                font: {
                    size: 12,
                    weight: 'bold'
                },
                formatter: (value, ctx) => {
                    const label = ctx.chart.data.labels[ctx.dataIndex];
                    return `${label}\n${value}%`;
                },
                anchor: 'center',
                align: 'center'
            }
        }
    },
    plugins: [ChartDataLabels]
});

setTimeout(() => {
    donutChart.data.datasets[0].data = donutValues;
    donutChart.update();
}, 300);