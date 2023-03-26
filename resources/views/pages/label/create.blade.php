<x-app-layout>
    <h1 class="mb-5">{{ __('label.create') }}</h1>

    {{ Form::open(['route' => 'labels.store', 'method' => 'post']) }}
        @include('pages.label._form', ['buttonText' => __('label.create')])
    {{ Form::close() }}
</x-app-layout>