<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold mb-4">Todo List</h2>

        <!-- Add Todo Form -->
        <form id="todoForm" class="mb-4 flex">
            <input type="text" id="todoTitle" placeholder="New Todo" required
                class="flex-1 px-3 py-2 border rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-r-md hover:bg-blue-700">Add</button>
        </form>

        <!-- Todo List -->
        <ul id="todoList" class="space-y-2">
            <!-- Dynamic Todos will be inserted here -->
        </ul>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const todoList = document.getElementById("todoList");
        const todoForm = document.getElementById("todoForm");
        const todoTitle = document.getElementById("todoTitle");

        // Fetch Todos
        async function fetchTodos() {
            const response = await fetch("/api/todos");
            const todos = await response.json();
            renderTodos(todos);
        }

        // Render Todos
        function renderTodos(todos) {
            todoList.innerHTML = "";
            todos.forEach(todo => {
                const li = document.createElement("li");
                li.className = "flex justify-between items-center p-2 bg-gray-100 rounded-md";

                li.innerHTML = `
                    <input type="text" value="${todo.title}" class="bg-transparent border-none focus:ring-0 w-full text-lg ${todo.completed ? 'line-through text-gray-500' : ''}"
                        onblur="updateTodo(${todo.id}, this.value)">
                    <div>
                        <button class="text-green-600 hover:text-green-800 mr-2" onclick="toggleComplete(${todo.id})">
                            ✅
                        </button>
                        <button class="text-red-600 hover:text-red-800" onclick="deleteTodo(${todo.id})">
                            ❌
                        </button>
                    </div>
                `;

                todoList.appendChild(li);
            });
        }

        // Add Todo
        todoForm.addEventListener("submit", async (e) => {
            e.preventDefault();
            const title = todoTitle.value.trim();
            if (!title) return;

            const response = await fetch("/api/todos", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ title, description: "" }),
            });

            if (response.ok) {
                todoTitle.value = "";
                fetchTodos();
            }
        });

        // Update Todo Title
        async function updateTodo(id, newTitle) {
            if (!newTitle.trim()) return;
            await fetch(`/api/todos/${id}`, {
                method: "PATCH",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ title: newTitle }),
            });
            fetchTodos();
        }

        // Mark Todo as Completed
        async function toggleComplete(id) {
            await fetch(`/api/todos/${id}/toggle`, { method: "PATCH" });
            fetchTodos();
        }

        // Delete Todo
        async function deleteTodo(id) {
            await fetch(`/api/todos/${id}`, { method: "DELETE" });
            fetchTodos();
        }

        // Initial Fetch
        fetchTodos();
    });
    </script>

</body>
</html>
