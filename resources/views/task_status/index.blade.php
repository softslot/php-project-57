<x-app-layout>
    <div class="grid col-span-full">
        <h1 class="mb-5">{{ __('main.statuses') }}</h1>

        <div>
            <a href="{{ route('task_statuses.create') }}"
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('main.create_status') }}
            </a>
        </div>

        <table class="mt-4">
            <thead class="border-b-2 border-solid border-black text-left">
            <tr>
                <th>{{ __('table.id') }}</th>
                <th>{{ __('table.name') }}</th>
                <th>{{ __('table.created_at') }}</th>
                <th>{{ __('table.actions') }}</th>
            </tr>
            </thead>
            <tbody>
                @foreach($taskStatuses as $taskStatus)
                <tr class="border-b border-dashed text-left">
                    <td>{{ $taskStatus->id }}</td>
                    <td>{{ $taskStatus->name }}</td>
                    <td>{{ date('d.m.Y', strtotime($taskStatus->created_at)) }}</td>
                    <td>
                        <a data-confirm="{{ __('table.confirm') }}"
                           data-method="delete"
                           class="text-red-600 hover:text-red-900"
                           href="{{ route('task_statuses.destroy', $taskStatus->id) }}">{{ __('table.delete') }}</a>
                        <a class="text-blue-600 hover:text-blue-900"
                           href="{{ route('task_statuses.edit', $taskStatus->id) }}">{{ __('table.edit') }}</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
