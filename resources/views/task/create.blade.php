<x-app-layout>
    <h1 class="mb-5">{{ __('task.create') }}</h1>

    <form method="POST" action="{{ route('tasks.store') }}" accept-charset="UTF-8">
        @include('task._form', ['buttonText' => __('task.create')])
    </form>
</x-app-layout>
