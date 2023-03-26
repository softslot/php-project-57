<x-app-layout>
    <h1 class="mb-5">{{ __('main.tasks') }}</h1>

    <div class="w-full flex items-center">
        <div>
           
            <form method="GET" action="{{ route('tasks.index') }}" accept-charset="UTF-8">
                <div class="flex">
                    <div>
                        <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="filter[status_id]">
                            <option selected="selected" value="">{{ __('task.status') }}</option>
                            @foreach ($taskStatuses as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="filter[created_by_id]">
                            <option selected="selected" value="">{{ __('task.author') }}</option>
                            @foreach ($users as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="filter[assigned_to_id]">
                            <option selected="selected" value="">{{ __('task.assigned') }}</option>
                            @foreach ($users as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-primary-button>{{ __('table.apply') }}</x-primary-button>
                    </div>
                </div>
            </form>
        </div>

        @can('create', App\Models\Task::class)
            <div class="ml-auto">
                <a href="{{ route('tasks.create') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
                    {{ __('task.create') }}
                </a>
            </div>
        @endcan
    </div>


    <div class="overflow-x-auto relative shadow-md sm:rounded-lg mt-10">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr scope="col" class="p-4">
                    <th scope="col" class="py-3 px-6">{{ __('task.id') }}</th>
                    <th scope="col" class="py-3 px-6">{{ __('task.status') }}</th>
                    <th scope="col" class="py-3 px-6">{{ __('task.name') }}</th>
                    <th scope="col" class="py-3 px-6">{{ __('task.author') }}</th>
                    <th scope="col" class="py-3 px-6">{{ __('task.assigned') }}</th>
                    <th scope="col" class="py-3 px-6">{{ __('task.created_at') }}</th>
                    @auth
                        <th scope="col" class="py-3 px-6">{{ __('table.actions') }}</th>
                    @endauth
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="p-4 w-4 text-center">{{ $task->id }}</td>
                    <td class="py-4 px-6">{{ $task->status->name }}</td>
                    <td class="py-4 px-6">
                        <a href="{{ route('tasks.show', $task->id) }}" class="text-blue-600 hover:text-blue-900">
                            {{ $task->name }}
                        </a>
                    </td>
                    <td class="py-4 px-6">{{ $task->creator->name }}</td>
                    <td class="py-4 px-6">{{ $task->executor?->name }}</td>
                    <td class="py-4 px-6">{{ date('d.m.Y', strtotime($task->created_at)) }}</td>
                    @auth
                        <td class="flex items-center py-4 px-6 space-x-3">
                            @can('delete', $task)
                                <a data-confirm="{{ __('table.confirm') }}"
                                    data-method="delete"
                                    class="text-red-600 hover:text-red-900"
                                    href="{{ route('tasks.destroy', $task->id) }}">{{ __('table.delete') }}</a>
                            @endcan

                            @can('update', $task)
                                <a href="{{ route('tasks.edit', $task->id) }}"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ __('table.edit') }}</a>
                            @endcan
                        </td>
                    @endauth
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $tasks->links() }}
    </div>
</x-app-layout>
