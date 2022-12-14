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
            ...$request->validated(),
            'created_by_id' => auth()->id(),
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
        $task->update($request->validated());

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
