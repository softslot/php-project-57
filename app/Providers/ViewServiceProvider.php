<?php

namespace App\Providers;

use App\View\Composers\LabelComposer;
use App\View\Composers\TaskStatusComposer;
use App\View\Composers\UserComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer([
            'task.index',
            'task.edit',
            'task.create',
        ], UserComposer::class);

        View::composer([
            'task.index',
            'task.edit',
            'task.create',
        ], TaskStatusComposer::class);

        View::composer([
            'task.edit',
            'task.create',
        ], LabelComposer::class);
    }
}
