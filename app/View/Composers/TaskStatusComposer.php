<?php

namespace App\View\Composers;

use App\Models\TaskStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class TaskStatusComposer
{
    protected Collection $taskStatuses;

    public function __construct()
    {
        $this->taskStatuses = TaskStatus::all();
    }

    public function compose(View $view): void
    {
        $view->with('taskStatuses', $this->taskStatuses);
    }
}
