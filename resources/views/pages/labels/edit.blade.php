<x-app-layout>
    <h1 class="mb-5">{{ __('label.edit') }}</h1>

    {{ Form::open(['route' => ['labels.update', $label->id], 'method' => 'put']) }}
        @include('pages.labels._form', ['buttonText' => __('label.edit')])
    {{ Form::close() }}
</x-app-layout>