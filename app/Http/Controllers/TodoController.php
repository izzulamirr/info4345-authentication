<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::user()->id;
        $todos = Todo::where('user_id', $userId)->get();
        return view('todo.list', ['todos' => $todos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('todo.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userId = Auth::user()->id;

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,completed',
        ]);

        $input = $request->all();
        $input['user_id'] = $userId;
        $todoStatus = Todo::create($input);

        if ($todoStatus) {
            return redirect('todo')->with('success', 'Todo successfully added');
        } else {
            return redirect('todo')->with('error', 'Oops, something went wrong. Todo not saved');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        $userId = Auth::user()->id;
        if ($todo->user_id !== $userId) {
            return redirect('todo')->with('error', 'Todo not found');
        }
        return view('todo.view', ['todo' => $todo]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todo $todo)
    {
        $userId = Auth::user()->id;
        if ($todo->user_id !== $userId) {
            return redirect('todo')->with('error', 'Todo not found');
        }
        return view('todo.edit', ['todo' => $todo]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo)
    {
        $userId = Auth::user()->id;
        if ($todo->user_id !== $userId) {
            return redirect('todo')->with('error', 'Todo not found.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,completed',
        ]);

        $todoStatus = $todo->update($request->all());

        if ($todoStatus) {
            return redirect('todo')->with('success', 'Todo successfully updated.');
        } else {
            return redirect('todo')->with('error', 'Oops something went wrong. Todo not updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        $userId = Auth::user()->id;
        if ($todo->user_id !== $userId) {
            return redirect('todo')->with('error', 'Todo not found');
        }

        if ($todo->delete()) {
            return redirect('todo')->with('success', 'Todo deleted successfully');
        }

        return redirect('todo')->with('error', 'Oops, something went wrong. Todo not deleted successfully');
    }
}