<x-app-layout>
    <div class="grid col-span-full">
        <h1 class="mb-5">{{ __('main.edit_status') }}</h1>

        <form method="POST" action="{{ route('task_statuses.update', $taskStatus->id) }}" accept-charset="UTF-8" class="w-50">
            @method('PUT')
            @csrf
            <div class="flex flex-col">
                <div>
                    <label for="name">{{ __('main.name') }}</label>
                </div>
                <div class="mt-2">
                    <input class="rounded border-gray-300 w-1/3"
                           name="name"
                           type="text"
                           id="name"
                           value="{{ $taskStatus->name }}">
                </div>
                <div class="mt-2">
                    <input class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                           type="submit"
                           value="{{ __('main.update') }}">
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
