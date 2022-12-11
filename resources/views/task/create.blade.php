<x-app-layout>
    <div class="grid col-span-full">
        <h1 class="mb-5">{{ __('task.create') }}</h1>
    
        <form method="POST" action="{{ route('tasks.store') }}" accept-charset="UTF-8" class="w-50">
            @csrf
            
            @include('task._form', ['buttonText' => __('task.create')])
        </form>
    </div>
</x-app-layout>
