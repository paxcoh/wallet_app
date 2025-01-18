document.addEventListener('DOMContentLoaded', () => {
    fetch('../api/visualization.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Transaction Summary Chart
                const transactionCtx = document.getElementById('transactionChart').getContext('2d');
                new Chart(transactionCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Income', 'Expenses'],
                        datasets: [{
                            data: [data.totalIncome, data.totalExpenses],
                            backgroundColor: ['#4caf50', '#f44336']
                        }]
                    }
                });

                fetch('../api/visualization.php')
                .then(response => response.json())
                .then(data => {
                console.log(data); // Check the response here
                });

                // Category Breakdown Chart
                const categoryCtx = document.getElementById('categoryChart').getContext('2d');
                new Chart(categoryCtx, {
                    type: 'bar',
                    data: {
                        labels: data.categoryBreakdown.labels,
                        datasets: [{
                            label: 'Expenses by Category',
                            data: data.categoryBreakdown.values,
                            backgroundColor: '#36a2eb'
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            } else {
                console.error('Failed to fetch data:', data.message);
            }
        })
        .catch(error => console.error('Error fetching visualization data:', error));
});

