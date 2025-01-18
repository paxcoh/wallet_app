document.addEventListener('DOMContentLoaded', () => {
    const addTransactionBtn = document.getElementById('add-transaction-btn');
    const transactionForm = document.getElementById('transaction-form');
    const budgetAlert = document.getElementById('budget-alert');
    const transactionsTable = document.getElementById('transactions-table').querySelector('tbody');

    // Toggle Transaction Form
    addTransactionBtn.addEventListener('click', () => {
        transactionForm.style.display = transactionForm.style.display === 'none' ? 'block' : 'none';
    });

    // Handle Transaction Form Submission
    transactionForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const transaction = {
            account_type: document.getElementById('account_type').value,
            category_id: document.getElementById('category_id').value,
            amount: parseFloat(document.getElementById('amount').value),
            type: document.getElementById('type').value,
            transaction_date: document.getElementById('transaction_date').value
        };

        const response = await fetch('../api/transactions.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(transaction)
        });

        const result = await response.json();

        if (result.success) {
            alert('Transaction added successfully!');
            addTransactionToTable(transaction);

            // Check if budget is being approached
            if (result.isApproachingBudget) {
                budgetAlert.textContent = `Warning: You are nearing your budget limit. Remaining: $${result.remainingBudget.toFixed(2)}`;
            } else {
                budgetAlert.textContent = '';
            }

            transactionForm.reset();
            transactionForm.style.display = 'none';
        } else {
            alert(result.message || 'Failed to add transaction!');
        }
    });

    // Helper: Add Transaction to Table
    function addTransactionToTable(transaction) {
        const row = transactionsTable.insertRow();
        row.innerHTML = `
            <td>${transaction.transaction_date}</td>
            <td>${transaction.type}</td>
            <td>${transaction.account_type}</td>
            <td>${transaction.category_id}</td>
            <td>${transaction.amount}</td>
        `;
    }
});
