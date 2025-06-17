<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Task::where('user_id', Auth()->id());
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status === 'completed') {
                $query->where('completed', true);
            } elseif ($status === 'pending') {
                $query->where('completed', false);
            }
        }
        $tasks = $query->orderBy('due_date', 'desc')
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('Tasks/Index', [
            'tasks' => $tasks,
            'filters' => [
                'status' => $status ?? null,
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(CreateTaskRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        Task::create($data);

        // Ao usar Inertia, um redirect normal atualiza a página
        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
