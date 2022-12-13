<x-app-layout>
    <div class="grid col-span-full">

    <h1 class="mb-5">{{ __('main.labels') }}</h1>

    <div>
        <a href="{{ route('labels.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            {{ __('label.create') }}
        </a>
    </div>

    <table class="mt-4">
        <thead class="border-b-2 border-solid border-black text-left">
            <tr>
                <th>{{ __('label.id') }}</th>
                <th>{{ __('label.name') }}</th>
                <th>{{ __('label.description') }}</th>
                <th>{{ __('label.created_at') }}</th>
                <th>{{ __('table.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($labels as $label)
            <tr class="border-b border-dashed text-left">
                <td>{{ $label->id }}</td>
                <td>{{ $label->name }}</td>
                <td>{{ $label->description }}</td>
                <td>{{ $label->created_at }}</td>
                <td>
                    <a data-confirm="{{ __('table.confirm') }}"
                    data-method="delete"
                    class="text-red-600 hover:text-red-900"
                    href="{{ route('labels.destroy', $label->id) }}">{{ __('table.delete') }}</a>
                    <a class="text-blue-600 hover:text-blue-900"
                    href="{{ route('labels.edit', $label->id) }}">{{ __('table.edit') }}</a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $labels->links() }}
        </div>
    </div>
</x-app-layout>