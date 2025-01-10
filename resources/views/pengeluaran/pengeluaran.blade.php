<x-layouts>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="bg-gray-900 min-h-screen p-6">
        <!-- Header -->
        <h1 class="text-4xl text-white font-bold mb-6">Manage Expenses</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
            @foreach ($category_expenses as $category)
                <div class="bg-gray-800 text-white p-4 rounded-lg shadow-lg hover:bg-gray-700 cursor-pointer"
                    onclick="showExpenses({{ json_encode($category) }})">
                    <h2 class="text-xl font-semibold">{{ $category->name }}</h2>
                </div>
            @endforeach
        </div>

        <!-- Expenses Table -->
        <div id="expenses-table" class="hidden">
            <h2 class="text-2xl text-white mb-4">Expenses</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-white bg-gray-800 rounded-lg">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-xs sm:text-sm">Nama</th>
                            <th class="px-4 py-2 text-xs sm:text-sm">Tanggal</th>
                            <th class="px-4 py-2 text-xs sm:text-sm">Total</th>
                            <th class="px-4 py-2 text-xs sm:text-sm">Deskripsi</th>
                            <th class="px-4 py-2 text-xs sm:text-sm">Metode</th>
                            <th class="px-4 py-2 text-xs sm:text-sm">Image</th>
                            <th class="px-4 py-2 text-xs sm:text-sm">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="expenses-body">
                        <!-- Rows will be populated dynamically -->
                    </tbody>
                </table>
            </div>
            <button id="add-expense-button"
                class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 hidden">
                Add Expense
            </button>
        </div>

        <!-- Modal for displaying large image -->
        <div id="imageModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden flex justify-center items-center">
            <div class="bg-white p-6 rounded-lg">
                <span class="absolute top-2 right-2 text-2xl cursor-pointer" onclick="closeModal()">&times;</span>
                <img id="modalImage" src="" alt="Expense Image" class="max-w-full h-auto">
            </div>
        </div>

        <script>
            // Simulate expenses fetching
            let allExpenses = @json($expenses);
            const userRole = @json(Auth::user()->role); // Getting user's role in JavaScript
            let selectedCategoryId = null; // Variable to store selected category

            function showExpenses(category) {
                // Store selected category ID
                selectedCategoryId = category.id;

                // Filter expenses by category
                const filteredExpenses = allExpenses.filter(expense => expense.category_id === category.id);

                // Populate table with expenses
                const tbody = document.getElementById('expenses-body');
                tbody.innerHTML = buildExpenseRows(filteredExpenses, category.role);
                document.getElementById('expenses-table').classList.remove('hidden');

                const addExpenseButton = document.getElementById('add-expense-button');

                // Show add expense button if user has proper role or category role is 0
                if (userRole == category.role || category.role == 0) {
                    addExpenseButton.classList.remove('hidden');

                    // Set the button's onclick dynamically to pass the selected category ID
                    addExpenseButton.setAttribute('onclick', `addExpense(${selectedCategoryId})`);
                } else {
                    addExpenseButton.classList.add('hidden');
                }
            }


            function buildExpenseRows(expenses, role) {
                return expenses.map(expense => {
                    // Ambil nama admin atau manajer jika admin tidak ada
                    const adminOrManagerName = expense.user.username;

                    return `
                        <tr class="bg-gray-800 hover:bg-gray-700">
                            <td class="px-4 py-2 text-xs sm:text-sm">${sanitize(adminOrManagerName)}</td>
                            <td class="px-4 py-2 text-xs sm:text-sm">${sanitize(expense.date)}</td>
                            <td class="px-4 py-2 text-xs sm:text-sm">${sanitize(expense.amount)}</td>
                            <td class="px-4 py-2 text-xs sm:text-sm">${sanitize(expense.description)}</td>
                            <td class="px-4 py-2 text-xs sm:text-sm">${sanitize(expense.method)}</td>
                            <td class="px-4 py-2 text-xs sm:text-sm">
                                <a href="#" onclick="openModal('${sanitize(expense.image_url)}')">
                                    <img src="${sanitize(expense.image_url)}" alt="Expense Image" class="h-16 w-16 object-cover rounded">
                                </a>
                            </td>
                            <td class="px-4 py-2 flex space-x-2 text-xs sm:text-sm">
                                ${ (userRole == role || role == 0) ? `
                                                                    <button class="px-2 py-1 bg-yellow-500 rounded text-white" onclick="editExpense(${expense.id})">Edit</button>
                                                                    <button class="px-2 py-1 bg-red-500 rounded text-white" onclick="deleteExpense(${expense.id})">Delete</button>
                                                                ` : '<p> Hanya untuk Manajer</p>' }
                            </td>
                        </tr>
                    `;
                }).join('');
            }

            function sanitize(input) {
                const div = document.createElement('div');
                div.innerText = input;
                return div.innerHTML;
            }

            function addExpense(categoryId) {
                console.log('Add expense clicked!');
                alert('Category ID: ' + categoryId);
            }

            function editExpense(expenseId) {
                alert(`Edit expense ${expenseId} clicked!`);
                // Redirect to edit expense form
            }

            function deleteExpense(expenseId) {
                if (confirm('Are you sure you want to delete this expense?')) {
                    alert(`Expense ${expenseId} deleted!`);
                    // Make an API call or form submission to delete
                }
            }

            // Open modal to show large image
            function openModal(imageUrl) {
                const modal = document.getElementById('imageModal');
                const modalImage = document.getElementById('modalImage');
                modal.classList.remove('hidden');
                modalImage.src = imageUrl;
            }

            // Pastikan modal tertutup jika klik di area gelap
            document.getElementById('imageModal').addEventListener('click', function(event) {
                if (event.target === this) {
                    closeModal();
                }
            });

            // Close modal
            function closeModal() {
                document.getElementById('imageModal').classList.add('hidden');
            }
        </script>
    </div>
</x-layouts>
