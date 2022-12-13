<x-app-layout>
    <div class="grid col-span-full">
        <h1 class="mb-5">{{ __('label.edit') }}</h1>
    
        <form method="POST" action="{{ route('labels.update', $label->id) }}" accept-charset="UTF-8" class="w-50">
            @method('PUT')
            @include('label._form', ['buttonText' => __('main.update')])
        </form>
    </div>
</x-app-layout>