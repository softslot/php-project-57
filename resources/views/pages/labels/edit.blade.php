<x-app-layout>
    <h1 class="mb-5">{{ __('label.edit') }}</h1>

    {{ Form::model($label, ['route' => ['labels.update', $label->id], 'method' => 'put']) }}
        @include('pages.labels._form', ['buttonText' => __('main.update')])
    {{ Form::close() }}
</x-app-layout>