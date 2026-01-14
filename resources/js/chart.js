// ========= MONTH CHART (History Page) =========
function initMonthChart() {
    const canvas = document.getElementById('monthChart');
    if (!canvas) return;

    const rawData = JSON.parse(canvas.getAttribute('data-chart'));
    const ctx = canvas.getContext('2d');

    const months = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];

    // 🔹 Group data by year
    const groupedByYear = {};
    rawData.forEach(item => {
        if (!groupedByYear[item.year]) {
            groupedByYear[item.year] = new Array(12).fill(null);
        }
        groupedByYear[item.year][item.month - 1] =
            parseFloat(item.remaining_budget) / 1000;
    });

    // 🔹 Colors (auto-cycle)
    const colors = [
        '#22c55e', '#3b82f6', '#06b6d4',
        '#f59e0b', '#a855f7', '#ef4444'
    ];

    let colorIndex = 0;

    // 🔹 Create datasets (one line per year)
    const datasets = Object.keys(groupedByYear)
        .sort((a, b) => b - a) // latest year first
        .map(year => {
            const data = groupedByYear[year];
            const color = colors[colorIndex++ % colors.length];

            return {
                label: `Monthly Total - ${year}`,
                data,
                borderColor: color,
                backgroundColor: color + '33',
                borderWidth: 2,
                tension: 0.3,
                fill: false,
                spanGaps: true
            };
        });

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: months,
            datasets
        },
        options: {
            ...chartOptions('Months'),
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });
}


// ========= DAY CHART (Dashboard Page) =========
function initDayChart() {
    const canvas = document.getElementById('dayChart');
    if (!canvas) return;

    const chartData = JSON.parse(canvas.getAttribute('data-chart'));
    const ctx = canvas.getContext('2d');

    const now = new Date();
    const daysInMonth = new Date(
        now.getFullYear(),
        now.getMonth() + 1,
        0
    ).getDate();

    const labels = Array.from({ length: daysInMonth }, (_, i) => i + 1);
    const values = new Array(daysInMonth).fill(null);

    chartData.forEach(item => {
        const date = new Date(item.day);
        const dayIndex = date.getDate() - 1;
        values[dayIndex] = parseFloat(item.net_total);
    });

    const initialValues = values.map(v => v !== null ? 0 : null);

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Net Amount',
                data: initialValues,
                borderWidth: 2,
                tension: 0.3,
                fill: false,
                spanGaps: true
            }]
        },
        options: {
            ...chartOptions('Days', true),
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 5000,
                        callback: function (value) {
                            return (value / 1000) + 'k';
                        }
                    }
                }
            }
        }
    });

    setTimeout(() => {
        chart.data.datasets[0].data = values;
        chart.update();
    }, 300);
}


// ========= SHARED OPTIONS =========
function chartOptions(xTitle, isDay = false) {
    return {
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
                    text: xTitle,
                    font: { size: 14, weight: 'bold' }
                }
            },
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Budget (in thousands)',
                    font: { size: 14, weight: 'bold' }
                },
                ticks: {
                    callback: value => value + 'k'
                }
            }
        },
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    title: ctx =>
                        isDay ? `Day ${ctx[0].dataIndex + 1}` : ctx[0].label,
                    label: ctx =>
                        `${ctx.dataset.label} ${ctx.parsed.y}k`
                }
            }
        }
    };
}


// ========= INITIALIZE =========
document.addEventListener('DOMContentLoaded', () => {
    initMonthChart();
    initDayChart();
});
