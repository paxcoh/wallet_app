<?php include '../includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/trans.css">
    <script src="../js/transactions.js" defer></script>
</head>
<body>
    <main>
        <h1>Transactions</h1>

        <!-- Add Transaction Button -->
        <button id="add-transaction-btn">Add Transaction</button>

        <!-- Transaction Form -->
        <form id="transaction-form" style="display: none;">
            <label for="account_type">Account Type:</label>
            <input type="text" id="account_type" placeholder="e.g., Bank, Mobile Money" required>

            <label for="category_id">Category ID:</label>
            <input type="number" id="category_id" placeholder="Category ID" required>

            <label for="amount">Amount:</label>
            <input type="number" id="amount" step="0.01" required>

            <label for="type">Transaction Type:</label>
            <select id="type" required>
                <option value="in">Income</option>
                <option value="out">Expense</option>
            </select>

            <label for="transaction_date">Date:</label>
            <input type="date" id="transaction_date" required>

            <button type="submit">Submit</button>
        </form>

        <p id="budget-alert" style="color: red; font-weight: bold;"></p>

        <section>
            <h2>Transaction History</h2>
            <table id="transactions-table">
                <thead>
                                
        <?php
        include '../db.php';

        // Fetch transactions
        $result = $conn->query("SELECT * FROM transactions ORDER BY transaction_date DESC");
        echo '<table>';
        echo '<tr><th>Date</th><th>Type</th><th>Account</th><th>Category</th><th>Amount</th></tr>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['transaction_date'] . '</td>';
            echo '<td>' . ucfirst($row['type']) . '</td>';
            echo '<td>' . $row['account_type'] . '</td>';
            echo '<td>' . $row['category_id'] . '</td>';
            echo '<td>' . $row['amount'] . '</td>';
            echo '</tr>';
        }

        echo '</table>';?>
                    
                </thead>
                <tbody></tbody>
            </table>
        </section>
    </main>
</body>
</html>

