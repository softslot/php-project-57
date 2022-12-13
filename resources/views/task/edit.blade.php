<x-app-layout>
    <h1 class="mb-5">{{ __('task.edit') }}</h1>

    <form method="POST" action="{{ route('tasks.update', $task->id) }}" accept-charset="UTF-8">
        @method('PUT')
        @include('task._form', ['buttonText' => __('task.edit')])
    </form>
</x-app-layout>
