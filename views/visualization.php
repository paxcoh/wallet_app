<?php
include '../db.php';
include '../includes/header.php';

// Fetch summary of income and expenses
$incomeQuery = "SELECT SUM(amount) AS total FROM transactions WHERE type='in'";
$expenseQuery = "SELECT SUM(amount) AS total FROM transactions WHERE type='out'";

$incomeResult = $conn->query($incomeQuery);
$expenseResult = $conn->query($expenseQuery);

$income = $incomeResult->fetch_assoc()['total'] ?? 0;
$expense = $expenseResult->fetch_assoc()['total'] ?? 0;

// Fetch category-wise breakdown
$categoryQuery = "
    SELECT c.name AS category, SUM(t.amount) AS total 
    FROM transactions t 
    JOIN categories c ON t.category_id = c.id 
    WHERE t.type='out' 
    GROUP BY c.name
";
$categoryResult = $conn->query($categoryQuery);

$categories = [];
$categoryTotals = [];

while ($row = $categoryResult->fetch_assoc()) {
    $categories[] = $row['category'];
    $categoryTotals[] = $row['total'];
}
?>

<h2>Transaction Summary</h2>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="/js/visual.js"></script>


<div style="width: 60%; margin: auto;">
    <canvas id="summaryChart"></canvas>
</div>

<h2>Expense Breakdown by Category</h2>
<div style="width: 60%; margin: auto;">
    <canvas id="categoryChart"></canvas>
</div>

<script>
// Summary Chart Data
const summaryData = {
    labels: ['Income', 'Expenses'],
    datasets: [{
        data: [<?php echo $income; ?>, <?php echo $expense; ?>],
        backgroundColor: ['#4caf50', '#f44336']
    }]
};

// Category Breakdown Data
const categoryData = {
    labels: <?php echo json_encode($categories); ?>,
    datasets: [{
        data: <?php echo json_encode($categoryTotals); ?>,
        backgroundColor: [
            '#ff6384', '#36a2eb', '#ffce56', '#4caf50', '#f44336'
        ]
    }]
};

// Initialize Charts
document.addEventListener('DOMContentLoaded', () => {
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
});
</script>

<?php include '../includes/footer.php'; ?>
