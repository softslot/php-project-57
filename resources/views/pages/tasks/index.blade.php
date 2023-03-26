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

    <x-table>
        <x-table.thead>
            <x-table.tr>
                <x-table.th class="text-center">{{ __('task.id') }}</x-table.th>
                <x-table.th>{{ __('task.status') }}</x-table.th>
                <x-table.th>{{ __('task.name') }}</x-table.th>
                <x-table.th>{{ __('task.author') }}</x-table.th>
                <x-table.th>{{ __('task.assigned') }}</x-table.th>
                <x-table.th>{{ __('task.created_at') }}</x-table.th>
                @auth
                    <x-table.th class="text-center">{{ __('table.actions') }}</x-table.th>
                @endauth
            </x-table.tr>
        </x-table.thead>
        
        <x-table.tbody>
            @foreach ($tasks as $task)
                <x-table.tr>
                    <x-table.td class="text-center">{{ $task->id }}</x-table.td>
                    <x-table.td>{{ $task->status->name }}</x-table.td>
                    <x-table.td>
                        <a href="{{ route('tasks.show', $task->id) }}" class="text-blue-600 hover:text-blue-900">
                            {{ $task->name }}
                        </a>
                    </x-table.td>
                    <x-table.td>{{ $task->creator->name }}</x-table.td>
                    <x-table.td>{{ $task->executor?->name }}</x-table.td>
                    <x-table.td>{{ date('d.m.Y', strtotime($task->created_at)) }}</x-table.td>
                    @auth
                        <x-table.td class="space-x-3 text-center">
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
                        </x-table.td>
                    @endauth
                </x-table.tr>
            @endforeach
        </x-table.tbody>
    </x-table>

    <div class="mt-4">
        {{ $tasks->links() }}
    </div>
</x-app-layout>
