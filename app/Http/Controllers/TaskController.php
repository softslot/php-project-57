<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function index(): Response
    {
        $tasks = Task::query()
            ->select(['*'])
            ->paginate();

        return response()->view('task.index', compact('tasks'));
    }

    public function create(): Response
    {
        return response()->view('task.create');
    }

    public function store(StoreTaskRequest $request)
    {
        $data = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'status_id' => $request->input('status_id'),
            'created_by_id' => auth()->id(),
            'assigned_to_id' => $request->input('assigned_to_id'),
        ];

        Task::query()->create($data);

        flash(__('task.added'))->success();

        return redirect()->route('tasks.index');
    }

    public function show(Task $task): Response
    {
        return response()->view('task.show', compact('task'));
    }

    public function edit(Task $task): Response
    {
        return response()->view('task.edit', compact('task'));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->input());

        flash(__('task.updated'))->success();

        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        if (auth()->id() !== $task->creator->id) {
            return redirect()->route('tasks.edit');
        }

        $task->delete();

        flash(__('task.deleted'))->success();

        return redirect()->route('tasks.index');
    }
}
