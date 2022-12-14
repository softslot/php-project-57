<?php

namespace App\View\Composers;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class UserComposer
{
    protected Collection $users;

    public function __construct()
    {
        $this->users = User::all();
    }

    public function compose(View $view): void
    {
        $view->with('users', $this->users);
    }
}
