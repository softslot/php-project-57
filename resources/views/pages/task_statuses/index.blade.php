<x-app-layout>
    <h1 class="mb-5">{{ __('main.statuses') }}</h1>

    @can('create', App\Models\TaskStatus::class)
        <div>
            <a href="{{ route('task_statuses.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('task_status.create') }}
            </a>
        </div>
    @endcan

    <x-table>
        <x-table.thead>
            <x-table.tr>
                <x-table.th class="text-center">{{ __('task_status.id') }}</x-table.th>
                <x-table.th>{{ __('task_status.name') }}</x-table.th>
                <x-table.th>{{ __('task_status.created_at') }}</x-table.th>
                @auth
                    <x-table.th class="text-center">{{ __('table.actions') }}</x-table.th>
                @endauth
            </x-table.tr>
        </x-table.thead>

        <x-table.tbody>
            @foreach ($taskStatuses as $taskStatus)
                <x-table.tr>
                    <x-table.td class="text-center">{{ $taskStatus->id }}</x-table.td>
                    <x-table.td>{{ $taskStatus->name }}</x-table.td>
                    <x-table.td>{{ $taskStatus->created_at->format('d.m.Y') }}</x-table.td>
                    @auth
                        <x-table.td class="space-x-3 text-center">
                            @can('delete', $taskStatus)
                                <a data-confirm="{{ __('table.confirm') }}"
                                    data-method="delete"
                                    class="text-red-600 hover:text-red-900"
                                    href="{{ route('task_statuses.destroy', $taskStatus->id) }}">{{ __('table.delete') }}</a>
                            @endcan

                            @can('update', $taskStatus)
                                <a class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                    href="{{ route('task_statuses.edit', $taskStatus->id) }}">{{ __('table.edit') }}</a>
                            @endcan
                        </x-table.td>
                    @endauth
                </x-table.tr>
            @endforeach
        </x-table.tbody>
    </x-table>

    <div class="mt-4">
        {{ $taskStatuses->links() }}
    </div>
</x-app-layout>
