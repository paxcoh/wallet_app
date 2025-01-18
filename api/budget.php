<?php
include '../db.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Save or update budget limit
    $data = json_decode(file_get_contents('php://input'), true);
    $budgetLimit = $data['budget_limit'];

    // Check if the user already has a budget
    $result = $conn->query("SELECT id FROM budgets WHERE user_id = $userId");

    if ($result->num_rows > 0) {
        // Update the existing budget
        $stmt = $conn->prepare("UPDATE budgets SET limit_amount = ?, notification_sent = FALSE WHERE user_id = ?");
        $stmt->bind_param("id", $budgetLimit, $userId);
    } else {
        // Insert a new budget
        $stmt = $conn->prepare("INSERT INTO budgets (user_id, limit_amount, notification_sent) VALUES (?, ?, FALSE)");
        $stmt->bind_param("id", $userId, $budgetLimit);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Budget limit saved successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save budget limit']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Retrieve budget limit
    $result = $conn->query("SELECT limit_amount, notification_sent FROM budgets WHERE user_id = $userId");

    if ($row = $result->fetch_assoc()) {
        echo json_encode(['success' => true, 'budget_limit' => $row['limit_amount'], 'notification_sent' => $row['notification_sent']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No budget found']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
?>
