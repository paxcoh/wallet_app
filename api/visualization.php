<?php
include '../db.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$userId = $_SESSION['user_id'];

// Total Income and Expenses
$incomeResult = $conn->query("SELECT SUM(amount) AS total FROM transactions WHERE user_id = $userId AND type = 'in'");
$totalIncome = $incomeResult->fetch_assoc()['total'] ?? 0;

$expenseResult = $conn->query("SELECT SUM(amount) AS total FROM transactions WHERE user_id = $userId AND type = 'out'");
$totalExpenses = $expenseResult->fetch_assoc()['total'] ?? 0;

// Category Breakdown
$categoryResult = $conn->query("
    SELECT c.name AS category, SUM(t.amount) AS total 
    FROM transactions t
    JOIN categories c ON t.category_id = c.id
    WHERE t.user_id = $userId AND t.type = 'out'
    GROUP BY c.name
");
$categories = [];
$categoryValues = [];

while ($row = $categoryResult->fetch_assoc()) {
    $categories[] = $row['category'];
    $categoryValues[] = $row['total'];
}

echo json_encode([
    'success' => true,
    'totalIncome' => $totalIncome,
    'totalExpenses' => $totalExpenses,
    'categoryBreakdown' => [
        'labels' => $categories,
        'values' => $categoryValues
    ]
]);
?>
