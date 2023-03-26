<x-app-layout>
    <h1 class="mb-5">{{ __('task_status.create') }}</h1>

    {{ Form::open(['route' => 'task_statuses.store', 'method' => 'post']) }}
        @include('pages.task_status._form', ['buttonText' => __('main.create')])
    {{ Form::close() }}
</x-app-layout>
