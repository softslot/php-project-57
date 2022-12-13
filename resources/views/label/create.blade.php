<x-app-layout>
    <h1 class="mb-5">{{ __('label.create') }}</h1>

    <form method="POST" action="{{ route('labels.store') }}" accept-charset="UTF-8">
        @include('label._form', ['buttonText' => __('main.create')])
    </form>
</x-app-layout>