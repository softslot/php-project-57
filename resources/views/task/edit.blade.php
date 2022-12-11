<x-app-layout>
    <div class="grid col-span-full">
        <h1 class="mb-5">{{ __('task.edit') }}</h1>
    
        <form method="POST" action="{{ route('tasks.update', $task->id) }}" accept-charset="UTF-8" class="w-50">
            @method('PUT')
            @csrf
            
            @include('task._form', ['buttonText' => __('task.edit')])
        </form>
    </div>
</x-app-layout>
