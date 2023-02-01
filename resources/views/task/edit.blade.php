<x-app-layout>
    <h1 class="mb-5">{{ __('task.edit') }}</h1>

    {{ Form::open(['route' => ['tasks.update', $task->id], 'method' => 'put']) }}
        @include('task._form', ['buttonText' => __('task.edit')])
    {{ Form::close() }}
</x-app-layout>
