<?php

namespace App\Policies;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TaskStatusPolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user): Response|bool
    {
        return true;
    }

    public function create(User $user): Response|bool
    {
        return true;
    }

    public function update(User $user, TaskStatus $taskStatus): Response|bool
    {
        return true;
    }

    public function delete(User $user, TaskStatus $taskStatus): Response|bool
    {
        return true;
    }
}
