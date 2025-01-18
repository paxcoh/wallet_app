document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('filter-form');
    const tableBody = document.getElementById('report-table').querySelector('tbody');
    const chartCanvas = document.getElementById('reportChart');

    let chartInstance; // Store Chart.js instance to update dynamically

    // Handle form submission
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;

        fetch(`../api/reports.php?start_date=${startDate}&end_date=${endDate}`)
            .then(response => response.json())
            .then(data => {
                populateTable(data);
                createChart(data);
            })
            .catch(error => console.error('Error fetching reports:', error));
    });

    const redirectButton = document.getElementById('sub');

    // Add click event to the button
    redirectButton.addEventListener('click', () => {
        // Redirect to another page (e.g., dashboard.php)
        window.location.href = 'dashboard.php';
    });

    // Populate the report table
    function populateTable(data) {
        tableBody.innerHTML = ''; // Clear existing rows
        data.forEach(transaction => {
            const row = tableBody.insertRow();
            row.innerHTML = `
                <td>${transaction.transaction_date}</td>
                <td>${transaction.type}</td>
                <td>${transaction.account_type}</td>
                <td>${transaction.category_id}</td>
                <td>${transaction.amount}</td>
            `;
        });
    }

    // Summary Chart
    new Chart(document.getElementById('summaryChart'), {
        type: 'pie',
        data: summaryData
    });

    // Category Chart
    new Chart(document.getElementById('categoryChart'), {
        type: 'bar',
        data: categoryData,
        options: {
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Create or update the Chart.js chart
    function createChart(data) {
        const categories = {};
        data.forEach(transaction => {
            const category = transaction.category_id;
            if (!categories[category]) {
                categories[category] = 0;
            }
            categories[category] += parseFloat(transaction.amount);
        });

        const labels = Object.keys(categories);
        const values = Object.values(categories);

        if (chartInstance) {
            chartInstance.destroy(); // Destroy the existing chart if it exists
        }

        chartInstance = new Chart(chartCanvas, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Expenses by Category',
                    data: values,
                    backgroundColor: [
                        '#ff6384', '#36a2eb', '#ffce56', '#4caf50', '#f44336'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
});

