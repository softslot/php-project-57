<x-app-layout>
    <h1 class="mb-5">{{ __('task_status.create') }}</h1>

    <form method="POST" action="{{ route('task_statuses.store') }}" accept-charset="UTF-8">
        @include('task_status._form', ['textButton' => __('main.create')])
    </form>
</x-app-layout>
