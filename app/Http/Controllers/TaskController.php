<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
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

        if ($request->has('priority')) {
            $priority = $request->input('priority');
            $query->where('priority', $priority);
        }

        $tasks = $query->orderBy('due_date', 'desc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Tasks/Index', [
            'tasks' => $tasks,
            'filters' => [
                'status' => $status ?? null,
                'priority' => $priority ?? null
            ],
        ]);
    }

    public function store(StoreTaskRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        Task::create($data);

        return redirect()->route('tasks.index');
    }

    public function complete(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }

        $task->update(['completed' => true]);

        return back();
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
