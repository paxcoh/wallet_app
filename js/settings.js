document.addEventListener('DOMContentLoaded', function () {
    // Budget Elements
    const budgetForm = document.getElementById('budget-form');
    const budgetLimitInput = document.getElementById('budget-limit');
    const budgetMessage = document.getElementById('budget-message');

    // Category Elements
    const categoryForm = document.getElementById('category-form');
    const categoryNameInput = document.getElementById('category-name');
    const parentCategorySelect = document.getElementById('parent-category');
    const categoriesList = document.getElementById('categories-list');

    // Load Existing Categories
    fetch('../api/categories.php')
        .then(response => response.json())
        .then(data => {
            populateCategories(data);
        })
        .catch(error => console.error('Error fetching categories:', error));

    // Handle Budget Form Submission
    budgetForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const budgetLimit = parseFloat(budgetLimitInput.value);

        fetch('../api/budget.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ budget_limit: budgetLimit })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    budgetMessage.textContent = 'Budget limit saved successfully!';
                    budgetMessage.style.color = 'green';
                } else {
                    budgetMessage.textContent = 'Failed to save budget.';
                    budgetMessage.style.color = 'red';
                }
            })
            .catch(error => console.error('Error saving budget:', error));
    });

    // Handle Category Form Submission
    categoryForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const categoryName = categoryNameInput.value;
        const parentCategory = parentCategorySelect.value;

        fetch('../api/categories.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ category_name: categoryName, parent_category: parentCategory })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Refresh the categories list
                    fetch('../api/categories.php')
                        .then(response => response.json())
                        .then(data => {
                            populateCategories(data);
                            categoryNameInput.value = '';
                        });
                } else {
                    alert('Failed to add category.');
                }
            })
            .catch(error => console.error('Error adding category:', error));
    });

    // Populate Categories List and Dropdown
    function populateCategories(data) {
        categoriesList.innerHTML = '';
        parentCategorySelect.innerHTML = '<option value="">None</option>';

        data.forEach(category => {
            // Add to list
            const listItem = document.createElement('li');
            listItem.textContent = category.name;

            const deleteButton = document.createElement('button');
            deleteButton.textContent = 'Delete';
            deleteButton.addEventListener('click', () => deleteCategory(category.id));

            listItem.appendChild(deleteButton);
            categoriesList.appendChild(listItem);

            // Add to dropdown
            const option = document.createElement('option');
            option.value = category.id;
            option.textContent = category.name;
            parentCategorySelect.appendChild(option);
        });
    }

    // Delete Category
    function deleteCategory(categoryId) {
        fetch(`../api/categories.php?id=${categoryId}`, {
            method: 'DELETE'
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Refresh categories
                    fetch('../api/categories.php')
                        .then(response => response.json())
                        .then(data => {
                            populateCategories(data);
                        });
                } else {
                    alert('Failed to delete category.');
                }
            })
            .catch(error => console.error('Error deleting category:', error));
    }
});
