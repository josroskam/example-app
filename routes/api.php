<?php 

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/todos', [TodoController::class, 'index']);
Route::post('/todos', [TodoController::class, 'store']);
Route::patch('/todos/{todo}/toggle', [TodoController::class, 'toggleComplete']);
Route::patch('/todos/{todo}', [TodoController::class, 'update']);
Route::delete('/todos/{todo}', [TodoController::class, 'destroy']);
Route::get('/todos-view', function () {
    return view('todo'); // Make sure todo.blade.php is inside resources/views
});