<div class="flex flex-col">
    <div>
        {{ Form::label('name', __('task_status.name')) }}
    </div>
    <div class="mt-2">
        {{ Form::text('name', options: ['class' => 'rounded border-gray-300 w-1/3']) }}
    </div>
    @error('name')
        <div class="text-rose-600">{{ $errors->first('name') }}</div>
    @enderror

    <div class="mt-2">
        <x-primary-button>{{ $buttonText }}</x-primary-button>
    </div>
</div>
