{{ Form::token() }}

<div class="flex flex-col">
    <div>
        {{ Form::label('name', __('label.name')) }}
    </div>
    <div class="mt-2">
        {{ Form::text('name', $label->name ?? null, ['class' => 'rounded border-gray-300 w-1/3']) }}
    </div>
    @error('name')
        <div class="text-rose-600">{{ $errors->first('name') }}</div>
    @enderror

    <div class="mt-2">
        {{ Form::label('description', __('label.description')) }}
    </div>
    <div class="mt-2">
        {{ Form::textarea('description', $label->description ?? null, ['rows' => 10, 'cols' => 50, 'class' => 'rounded border-gray-300 w-1/3 h-32']) }}
    </div>

    <div class="mt-2">
        <x-primary-button>{{ $buttonText }}</x-primary-button>
    </div>
</div>