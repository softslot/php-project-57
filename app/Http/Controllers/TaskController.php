<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }

    public function index(Request $request): View
    {
        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters([
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('assigned_to_id'),
            ])
            ->with([
                'createdBy',
                'assignedTo',
                'status',
            ])
            ->paginate();

        $filter = $request->get('filter');

        return view('pages.tasks.index', compact('tasks', 'filter'));
    }

    public function create(): View
    {
        return view('pages.tasks.create');
    }

    public function store(StoreTaskRequest $request)
    {
        $validatedData = $request->validated();

        $task = new Task();
        $task->fill([
            ...$validatedData,
            'created_by_id' => auth()->id(),
        ]);
        $task->save();

        if (isset($validatedData['labels'])) {
            $task->labels()->sync($validatedData['labels']);
        }

        flash(__('task.added'))->success();

        return redirect()->route('tasks.index');
    }

    public function show(Task $task): View
    {
        return view('pages.tasks.show', compact('task'));
    }

    public function edit(Task $task): View
    {
        return view('pages.tasks.edit', compact('task'));
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
        if ($task->createdBy?->id !== auth()->id()) {
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
