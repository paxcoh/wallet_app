<?php
include '../db.php';
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $userId = $_SESSION['user_id'];
    $accountType = $data['account_type'];
    $categoryId = $data['category_id'];
    $amount = $data['amount'];
    $type = $data['type'];
    $transactionDate = $data['transaction_date'];

    // Insert the transaction
    $stmt = $conn->prepare("INSERT INTO transactions (user_id, account_type, category_id, amount, type, transaction_date) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issdss", $userId, $accountType, $categoryId, $amount, $type, $transactionDate);

    if ($stmt->execute()) {
        // Calculate remaining budget
        $expenseResult = $conn->query("SELECT SUM(amount) AS total_expenses FROM transactions WHERE user_id = $userId AND type = 'out'");
        $totalExpenses = $expenseResult->fetch_assoc()['total_expenses'] ?? 0;

        $budgetResult = $conn->query("SELECT limit_amount FROM budgets WHERE user_id = $userId LIMIT 1");
        $budgetLimit = $budgetResult->fetch_assoc()['limit_amount'] ?? 0;

        $remainingBudget = $budgetLimit - $totalExpenses;

        // Alert if approaching the budget
        $threshold = 0.1 * $budgetLimit; // 10% of budget
        $isApproachingBudget = ($remainingBudget <= $threshold);

        echo json_encode([
            'success' => true,
            'message' => 'Transaction added successfully',
            'remainingBudget' => $remainingBudget,
            'isApproachingBudget' => $isApproachingBudget
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add transaction']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}

?>
