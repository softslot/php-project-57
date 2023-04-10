<?php

use App\Http\Controllers\LabelController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskStatusController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.home')->name('home');

Route::resource('tasks', TaskController::class);

Route::resources(
    [
        'task_statuses' => TaskStatusController::class,
        'labels' => LabelController::class,
    ],
    ['except' => 'show']
);

require __DIR__ . '/auth.php';
