<x-app-layout>
    <div class="grid col-span-full">
        <h1 class="mb-5">{{ __('task_status.edit') }}</h1>

        <form method="POST" action="{{ route('task_statuses.update', $taskStatus->id) }}" accept-charset="UTF-8" class="w-50">
            @method('PUT')
            @csrf

            @include('task_status._form', ['textButton' => __('main.update')])
        </form>
    </div>
</x-app-layout>
