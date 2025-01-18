<?php
// session_start();
// if (!isset($_SESSION['user_id'])) {
//     header('Location: login.php');
//     exit();
// }

include '../db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="/css/dash.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../js/dashboard.js" defer></script>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="dashboard.php">Home</a></li>
                <li><a href="transactions.php">Transactions</a></li>
                <li><a href="reports.php">Reports</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="../api/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Welcome to Your Dashboard</h1>

        <!-- Metrics Section -->
        <section class="metrics">
            <div class="metric">
                <h3>Total Income</h3>
                <p id="total-income">$0</p>
            </div>
            <div class="metric">
                <h3>Total Expenses</h3>
                <p id="total-expenses">$0</p>
            </div>
            <div class="metric">
                <h3>Remaining Budget</h3>
                <p id="remaining-budget">$0</p>
            </div>
        </section>

        <!-- Transaction Summary Chart -->
        <section class="chart-section">
            <h2>Transaction Summary</h2>
            <canvas id="transactionChart"></canvas>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Wallet App. All Rights Reserved.</p>
    </footer>
</body>
</html>
