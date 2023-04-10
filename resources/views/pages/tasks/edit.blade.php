<x-app-layout>
    <h1 class="mb-5">{{ __('task.edit') }}</h1>

    {{ Form::model($task, ['route' => ['tasks.update', $task->id], 'method' => 'put']) }}
        @include('pages.tasks._form', ['buttonText' => __('main.update')])
    {{ Form::close() }}
</x-app-layout>
