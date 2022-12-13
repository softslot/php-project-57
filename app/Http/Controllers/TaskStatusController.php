<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskStatusRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use App\Models\TaskStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TaskStatusController extends Controller
{
    public function index(): View
    {
        $taskStatuses = DB::table('task_statuses')
            ->select(['*'])
            ->paginate();

        return view('task_status.index', compact('taskStatuses'));
    }

    public function create(): View
    {
        if (auth()->guest()) {
            return abort(403);
        }

        return view('task_status.create');
    }

    public function store(StoreTaskStatusRequest $request): RedirectResponse
    {
        $data = [
            'name' => $request->input('name'),
            'user_id' => auth()->id(),
        ];

        TaskStatus::query()
            ->create($data)
            ->save();

        flash(__('task_status.added'))->success()->important();

        return redirect()->route('task_statuses.index');
    }

    public function edit(TaskStatus $taskStatus): View
    {
        if (auth()->guest()) {
            return abort(403);
        }

        return view('task_status.edit', compact('taskStatus'));
    }

    public function update(UpdateTaskStatusRequest $request, TaskStatus $taskStatus): RedirectResponse
    {
        if (auth()->guest()) {
            return abort(403);
        }

        $taskStatus->update($request->input());
        flash(__('task_status.updated'))->success();

        return redirect()->route('task_statuses.index');
    }

    public function destroy(TaskStatus $taskStatus): RedirectResponse
    {
        if (auth()->guest()) {
            return abort(403);
        }

        if ($taskStatus->user_id !== auth()->id()) {
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
