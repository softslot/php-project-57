<x-app-layout>
    <h1 class="mb-5">{{ __('task_status.edit') }}</h1>

    <form method="POST" action="{{ route('task_statuses.update', $taskStatus->id) }}" accept-charset="UTF-8">
        @method('PUT')
        @include('task_status._form', ['textButton' => __('main.update')])
    </form>
</x-app-layout>
