// Check if we're on history page or dashboard
const chartCanvas = document.getElementById('lineChart');
if (chartCanvas) {
    const chartData = JSON.parse(chartCanvas.getAttribute('data-chart'));
    const isHistoryPage = window.location.pathname.includes('history');
    
    const lineCtx = chartCanvas.getContext('2d');
    
    let lineLabels, lineValues, xAxisTitle;
    
    if (isHistoryPage) {
        // FOR HISTORY PAGE - Display by months
        lineLabels = chartData.map(item => item.month_name);
        lineValues = chartData.map(item => parseFloat(item.remaining_budget) / 1000); // Convert to thousands
        xAxisTitle = 'Months';
    } else {
        // FOR DASHBOARD - Display by days
        const currentMonth = new Date().getMonth();
        const currentYear = new Date().getFullYear();
        const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
        
        lineLabels = Array.from({ length: daysInMonth }, (_, i) => i + 1);
        lineValues = new Array(daysInMonth).fill(null);
        
        // Parse chart data and populate days
        if (chartData && chartData.length > 0) {
            chartData.forEach(item => {
                const date = new Date(item.date);
                const day = date.getDate();
                if (day <= daysInMonth) {
                    lineValues[day - 1] = parseFloat(item.remaining_budget) / 1000;
                }
            });
        }
        
        xAxisTitle = 'Days';
    }
    
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
                tension: 0.3,
                fill: true,
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
                        text: xAxisTitle,
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
                            if (isHistoryPage) {
                                return context[0].label;
                            } else {
                                const day = context[0].dataIndex + 1;
                                return `Day ${day}`;
                            }
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
}

// Donut chart (only for dashboard)
const donutCanvas = document.getElementById('donutChart');
if (donutCanvas) {
    const donutCtx = donutCanvas.getContext('2d');

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
}