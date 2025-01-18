document.addEventListener('DOMContentLoaded', async () => {
    // Fetch metrics and transaction data
    const response = await fetch('../api/dashboard.php');
    const data = await response.json();

    // Update metrics
    document.getElementById('total-income').textContent = `$${data.totalIncome}`;
    document.getElementById('total-expenses').textContent = `$${data.totalExpenses}`;
    document.getElementById('remaining-budget').textContent = `$${data.remainingBudget}`;

    // Create Transaction Summary Chart
    const ctx = document.getElementById('transactionChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Income', 'Expenses'],
            datasets: [{
                data: [data.totalIncome, data.totalExpenses],
                backgroundColor: ['#4caf50', '#f44336'],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
