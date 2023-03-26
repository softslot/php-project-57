<?php

namespace App\Policies;

use App\Models\Label;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class LabelPolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user): Response|bool
    {
        return true;
    }

    public function view(User $user, Label $label): Response|bool
    {
        return true;
    }

    public function create(User $user): Response|bool
    {
        return true;
    }

    public function update(User $user, Label $label): Response|bool
    {
        return true;
    }

    public function delete(User $user, Label $label): Response|bool
    {
        return true;
    }
}
