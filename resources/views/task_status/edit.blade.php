<x-app-layout>
    <h1 class="mb-5">{{ __('task_status.edit') }}</h1>

    {{ Form::open(['route' => ['task_statuses.update', $taskStatus->id], 'method' => 'put']) }}
        @include('task_status._form', ['buttonText' => __('main.update')])
    {{ Form::close() }}
</x-app-layout>
