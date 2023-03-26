<?php

namespace App\View\Composers;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class UserComposer
{
    protected Collection $users;

    public function __construct()
    {
        $this->users = User::pluck('name', 'id');
    }

    public function compose(View $view): void
    {
        $view->with('users', $this->users);
    }
}
