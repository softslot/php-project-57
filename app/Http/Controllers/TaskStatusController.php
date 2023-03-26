<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskStatusRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use App\Models\TaskStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TaskStatusController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(TaskStatus::class, 'task_status');
    }

    public function index(): View
    {
        $taskStatuses = TaskStatus::paginate();

        return view('pages.task_statuses.index', compact('taskStatuses'));
    }

    public function create(): View
    {
        return view('pages.task_statuses.create');
    }

    public function store(StoreTaskStatusRequest $request): RedirectResponse
    {
        TaskStatus::create($request->validated())
            ->save();

        flash(__('task_status.added'))->success()->important();

        return redirect()->route('task_statuses.index');
    }

    public function edit(TaskStatus $taskStatus): View
    {
        return view('pages.task_statuses.edit', compact('taskStatus'));
    }

    public function update(UpdateTaskStatusRequest $request, TaskStatus $taskStatus): RedirectResponse
    {
        $taskStatus->update($request->validated());

        flash(__('task_status.updated'))->success();

        return redirect()->route('task_statuses.index');
    }

    public function destroy(TaskStatus $taskStatus): RedirectResponse
    {
        if ($taskStatus->tasks()->exists()) {
            flash(__('task_status.not_deleted'))->error();

            return redirect()
                ->route('task_statuses.index')
                ->withErrors(__('task_status.not_deleted'));
        }

        $taskStatus->delete();

        flash(__('task_status.deleted'))->success();

        return redirect()->route('task_statuses.index');
    }
}
