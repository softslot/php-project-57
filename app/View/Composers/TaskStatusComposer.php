<?php

namespace App\View\Composers;

use App\Models\TaskStatus;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class TaskStatusComposer
{
    protected Collection $taskStatuses;

    public function __construct()
    {
        $this->taskStatuses = TaskStatus::pluck('name', 'id');
    }

    public function compose(View $view): void
    {
        $view->with('taskStatuses', $this->taskStatuses);
    }
}
