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
                    text: 'Budget',
                    font: { size: 14, weight: 'bold' }
                },
                ticks: {
                    callback: value => value.toLocaleString()
                }
            }
        },
        plugins: {
            legend: {
                display: !isDay
            },
            tooltip: {
                callbacks: {
                    title: ctx =>
                        isDay ? `Day ${ctx[0].dataIndex + 1}` : ctx[0].label,
                    label: ctx => {
                        const val = ctx.parsed.y;
                        return `${ctx.dataset.label}: ${val.toLocaleString()}`;
                    }
                }
            }
        }
    };
}

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

    // Group data by year (NO /1000)
    const groupedByYear = {};
    rawData.forEach(item => {
        if (!groupedByYear[item.year]) {
            groupedByYear[item.year] = new Array(12).fill(null);
        }
        groupedByYear[item.year][item.month - 1] =
            Number(item.remaining_budget);
    });

    const colors = ['#22c55e', '#3b82f6', '#06b6d4', '#f59e0b', '#a855f7', '#ef4444'];
    let colorIndex = 0;

    const datasets = Object.keys(groupedByYear)
        .sort((a, b) => b - a)
        .map(year => {
            const color = colors[colorIndex++ % colors.length];
            return {
                label: `Monthly Total - ${year}`,
                data: groupedByYear[year],
                borderColor: color,
                backgroundColor: color + '33',
                borderWidth: 1,
                tension: 0,
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
        options: chartOptions('Months', false)
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
        values[dayIndex] = Number(item.net_total); // NO /1000
    });

    const initialValues = values.map(v => (v !== null ? 0 : null));

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Net Amount',
                data: initialValues,
                borderColor: '#22c55e',
                backgroundColor: '#22c55e33',
                borderWidth: 1,
                tension: 0,
                fill: false,
                spanGaps: true
            }]
        },
        options: chartOptions('Days', true)
    });

    // Animate after load
    setTimeout(() => {
        chart.data.datasets[0].data = values;
        chart.update();
    }, 300);
}

// ========= INITIALIZE =========
document.addEventListener('DOMContentLoaded', () => {
    initMonthChart();
    initDayChart();
});
