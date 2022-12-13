@csrf

<div class="flex flex-col">
    <div>
        <label for="name">{{ __('label.name') }}</label>
    </div>
    <div class="mt-2">
        <input class="rounded border-gray-300 w-1/3"
               name="name"
               type="text"
               id="name" value="{{ old('name', $label->name ?? '') }}">
    </div>
    <div class="mt-2">
        <label for="description">{{ __('label.description') }}</label>
    </div>
    <div class="mt-2">
        <textarea class="rounded border-gray-300 w-1/3 h-32"
                  name="description"
                  cols="50"
                  rows="10"
                  id="description">{{ old('description', $label->description ?? '') }}</textarea>
    </div>
    <div class="mt-2">
        <x-primary-button>{{ $buttonText }}</x-primary-button>
    </div>
</div>