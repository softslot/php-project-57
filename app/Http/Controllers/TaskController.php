<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
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

        $taskStatuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');

        return view('pages.tasks.index', compact(
            'tasks',
            'filter',
            'taskStatuses',
            'users',
        ));
    }

    public function create(): View
    {
        $taskStatuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');

        return view('pages.tasks.create', compact(
            'taskStatuses',
            'users',
            'labels',
        ));
    }

    public function store(StoreTaskRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $task = auth()->user()->createdTasks()->create($validatedData);

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
        $taskStatuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');

        return view('pages.tasks.edit', compact(
            'task',
            'taskStatuses',
            'users',
            'labels',
        ));
    }

    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
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

    public function destroy(Task $task): RedirectResponse
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
