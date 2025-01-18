//transaction js
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("transaction-form");
    const transactionsTable = document.getElementById("transactions-table").getElementsByTagName("tbody")[0];

    // Load existing transactions
    fetch("../api/transactions.php")
        .then(response => response.json())
        .then(data => {
            data.forEach(transaction => {
                addTransactionToTable(transaction);
            });
        });

    // Add transaction
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const newTransaction = {
            account_type: document.getElementById("account_type").value,
            category_id: document.getElementById("category_id").value,
            amount: parseFloat(document.getElementById("amount").value),
            type: document.getElementById("type").value,
            transaction_date: document.getElementById("transaction_date").value
        };

        fetch("../api/transactions.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(newTransaction)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                addTransactionToTable(newTransaction);
                form.reset();
            } else {
                alert(data.message);
            }
        });
    });

    // Add transaction to table
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

