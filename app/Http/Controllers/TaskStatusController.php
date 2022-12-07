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
            ->get();

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

        flash(__('flash.status_added'))->success();

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
        flash(__('flash.status_edited'))->success();

        return redirect()->route('task_statuses.index');
    }

    public function destroy(TaskStatus $taskStatus): RedirectResponse
    {
        if (auth()->guest()) {
            return abort(403);
        }

        if ($taskStatus->user_id !== auth()->id()) {
            flash(__('flash.status_not_deleted'))->error();

            return redirect()
                ->route('task_statuses.index')
                ->withErrors(__('flash.status_not_deleted'));
        }

        $taskStatus->delete();
        flash(__('flash.status_deleted'))->success();

        return redirect()->route('task_statuses.index');
    }
}
