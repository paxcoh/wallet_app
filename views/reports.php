<?php
include '../db.php';
include '../includes/header.php';

// Fetch report
if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
    $start = $_POST['start_date'];
    $end = $_POST['end_date'];
    $stmt = $conn->prepare("SELECT * FROM transactions WHERE transaction_date BETWEEN ? AND ?");
    $stmt->bind_param("ss", $start, $end);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM transactions");
}

echo '<h2>Reports</h2>';
echo '<form method="post">';
echo 'Start Date: <input type="date" name="start_date">';
echo 'End Date: <input type="date" name="end_date">';
echo '<button type="submit">Generate</button>';
echo '</form>';

echo '<table>';
echo '<tr><th>Date</th><th>Type</th><th>Amount</th></tr>';

while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $row['transaction_date'] . '</td>';
    echo '<td>' . ucfirst($row['type']) . '</td>';
    echo '<td>' . $row['amount'] . '</td>';
    echo '</tr>';
}

echo '</table>';

include '../includes/footer.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/report.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2>Transaction Reports</h2>

    <!-- Filter Form -->
    <form id="filter-form">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" required>
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" required>
        <button type="submit">Generate Report</button>
    </form>

    <!-- Report Summary Table -->
    <h3>Report Summary</h3>
    <table id="report-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Account</th>
                <th>Category</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <script src="../js/reports.js"></script>
</body>
</html>
