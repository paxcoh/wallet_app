<?php
include '../db.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch total income
$incomeResult = $conn->query("SELECT SUM(amount) AS total FROM transactions WHERE user_id = $userId AND type = 'in'");
$totalIncome = $incomeResult->fetch_assoc()['total'] ?? 0;

// Fetch total expenses
$expensesResult = $conn->query("SELECT SUM(amount) AS total FROM transactions WHERE user_id = $userId AND type = 'out'");
$totalExpenses = $expensesResult->fetch_assoc()['total'] ?? 0;

// Fetch remaining budget
$budgetResult = $conn->query("SELECT limit_amount FROM budgets WHERE user_id = $userId LIMIT 1");
$budgetLimit = $budgetResult->fetch_assoc()['limit_amount'] ?? 0;
$remainingBudget = $budgetLimit - $totalExpenses;

echo json_encode([
    'success' => true,
    'totalIncome' => $totalIncome,
    'totalExpenses' => $totalExpenses,
    'remainingBudget' => $remainingBudget
]);
?>
