<x-app-layout>
    <div class="grid col-span-full">
        <h1 class="mb-5">{{ __('label.create') }}</h1>
    
        <form method="POST" action="{{ route('labels.store') }}" accept-charset="UTF-8" class="w-50">
            @include('label._form', ['buttonText' => __('main.create')])
        </form>
    </div>
</x-app-layout>