<?php include '../includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/settings.js" defer></script>
</head>
<body>
    <main>
        <h1>Settings</h1>

        <!-- Budget Settings -->
        <section>
            <h2>Budget Settings</h2>
            <form id="budget-form">
                <label for="budget-limit">Set Budget Limit:</label>
                <input type="number" id="budget-limit" placeholder="Enter budget limit" required>
                <button type="submit">Save</button>
            </form>
            <div id="budget-feedback"></div>
        </section>

        <!-- Manage Categories -->
        <section>
            <h2>Manage Categories</h2>
            <form id="category-form">
                <label for="category-name">Category Name:</label>
                <input type="text" id="category-name" placeholder="Enter category name" required>
                <label for="parent-category">Parent Category:</label>
                <select id="parent-category">
                    <option value="">None</option>
                </select>
                <button type="submit">Add Category</button>
            </form>

            <h3>Existing Categories</h3>
            <ul id="categories-list"></ul>
        </section>
    </main>
</body>
</html>