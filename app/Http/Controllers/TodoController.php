<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all todos
        $todos = Todo::all();

        Log::debug('Todos fetched');

        // Return the fetched todos
        return response()->json($todos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        $todo = new Todo;
        $todo->title = $request->title;
        $todo->description = $request->description;
        $todo->completed = false;
        $todo->save();

        return response()->json($todo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo)
    {
        $request->validate(['title' => 'required|string|max:255']);
        $todo->title = $request->title;
        $todo->save();
        return response()->json($todo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Todo $todo)
    {
        $todo->delete();
        return response()->json(['message' => 'Todo deleted']);
    }

    public function toggleComplete(Todo $todo)
    {
        $todo->completed = !$todo->completed;
        $todo->save();
        return response()->json($todo);
    }
}