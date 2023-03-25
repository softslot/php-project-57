<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }

    public function index(): Response
    {
        $tasks = Task::with([
            'creator',
            'executor',
            'status',
        ])
        ->paginate();

        return response()->view('task.index', compact('tasks'));
    }

    public function create(): Response
    {
        return response()->view('task.create');
    }

    public function store(StoreTaskRequest $request)
    {
        $validatedData = $request->validated();

        $task = Task::create([
            ...$validatedData,
            'created_by_id' => auth()->id(),
        ]);

        if (isset($validatedData['labels'])) {
            $task->labels()->sync($validatedData['labels']);
        }

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
        $validatedData = $request->validated();

        $task->update($validatedData);

        if (isset($validatedData['labels'])) {
            $task->labels()->sync($validatedData['labels']);
        } else {
            $task->labels()->detach();
        }

        flash(__('task.updated'))->success();

        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        if ($task->creator->id !== auth()->id()) {
            flash(__('task.not_deleted'))->error();

            return redirect()
                ->route('tasks.index')
                ->withErrors(__('task.not_deleted'));
        }

        $task->labels()->detach();
        $task->delete();

        flash(__('task.deleted'))->success();

        return redirect()->route('tasks.index');
    }
}
