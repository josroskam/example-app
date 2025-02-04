<?php 

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/todos', [TodoController::class, 'index']);
Route::post('/todos', [TodoController::class, 'create']);
Route::patch('/todos/{todo}/toggle', [TodoController::class, 'toggleComplete']);
Route::put('/todos/{todo}', [TodoController::class, 'update']);
Route::delete('/todos/{todo}', [TodoController::class, 'delete']);

// add sanctum middleware to all routes