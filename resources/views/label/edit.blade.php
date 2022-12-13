<x-app-layout>
    <h1 class="mb-5">{{ __('label.edit') }}</h1>

    <form method="POST" action="{{ route('labels.update', $label->id) }}" accept-charset="UTF-8">
        @method('PUT')
        @include('label._form', ['buttonText' => __('main.update')])
    </form>
</x-app-layout>