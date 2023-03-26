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
            'pages.tasks.index',
            'pages.tasks.edit',
            'pages.tasks.create',
        ], UserComposer::class);

        View::composer([
            'pages.tasks.index',
            'pages.tasks.edit',
            'pages.tasks.create',
        ], TaskStatusComposer::class);

        View::composer([
            'pages.tasks.edit',
            'pages.tasks.create',
        ], LabelComposer::class);
    }
}
