<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user): Response|bool
    {
        return true;
    }

    public function view(?User $user, Task $task): Response|bool
    {
        return true;
    }

    public function create(User $user): Response|bool
    {
        return true;
    }

    public function update(User $user, Task $task): Response|bool
    {
        return true;
    }

    public function delete(User $user, Task $task): Response|bool
    {
        return $task->creator->is($user);
    }
}
