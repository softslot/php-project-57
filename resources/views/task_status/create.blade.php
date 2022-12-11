<x-app-layout>
    <div class="grid col-span-full">
        <h1 class="mb-5">{{ __('task_status.create') }}</h1>

        <form method="POST" action="{{ route('task_statuses.store') }}" accept-charset="UTF-8" class="w-50">
            @csrf

            @include('task_status._form', ['textButton' => __('main.create')])
        </form>
    </div>
</x-app-layout>
