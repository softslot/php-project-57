<x-app-layout>
    <h1 class="mb-5">{{ __('main.labels') }}</h1>

    @can('create', App\Models\Label::class)
        <div>
            <a href="{{ route('labels.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('label.create') }}
            </a>
        </div>
    @endcan

    <x-table>
        <x-table.thead>
            <x-table.tr>
                <x-table.th class="text-center">{{ __('label.id') }}</x-table.th>
                <x-table.th>{{ __('label.name') }}</x-table.th>
                <x-table.th>{{ __('label.description') }}</x-table.th>
                <x-table.th>{{ __('label.created_at') }}</x-table.th>
                @auth
                    <x-table.th class="text-center">{{ __('table.actions') }}</x-table.th>
                @endauth
            </x-table.tr>
        </x-table.thead>
        
        <x-table.tbody>
            @foreach ($labels as $label)
                <x-table.tr>
                    <x-table.td class="text-center">{{ $label->id }}</x-table.td>
                    <x-table.td>{{ $label->name }}</x-table.td>
                    <x-table.td>{{ $label->description }}</x-table.td>
                    <x-table.td>{{ $label->created_at }}</x-table.td>
                    @auth
                        <x-table.td class="space-x-3 text-center">
                            @can('delete', $label)
                                <a data-confirm="{{ __('table.confirm') }}"
                                    data-method="delete"
                                    class="text-red-600 hover:text-red-900"
                                    href="{{ route('labels.destroy', $label->id) }}">{{ __('table.delete') }}</a>
                            @endcan

                            @can('update', $label)
                                <a class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                    href="{{ route('labels.edit', $label->id) }}">{{ __('table.edit') }}</a>
                            @endcan
                        </x-table.td>
                    @endauth
                </x-table.tr>
            @endforeach
        </x-table.tbody>
    </x-table>

    <div class="mt-4">
        {{ $labels->links() }}
    </div>
</x-app-layout>