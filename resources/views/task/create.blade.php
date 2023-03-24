<x-app-layout>
    <h1 class="mb-5">{{ __('task.create') }}</h1>

    {{ Form::open(['route' => 'tasks.store', 'method' => 'post']) }}
        @include('task._form', ['buttonText' => __('main.create')])
    {{ Form::close() }}
</x-app-layout>
