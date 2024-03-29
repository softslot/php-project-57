<div class="flex flex-col">
    <div>
        {{ Form::label('name', __('task.name')) }}
    </div>
    <div class="mt-2">
        {{ Form::text('name', options: ['class' => 'rounded border-gray-300 w-1/3']) }}
    </div>
    @error('name')
        <div class="text-rose-600">{{ $errors->first('name') }}</div>
    @enderror

    <div class="mt-2">
        {{ Form::label('description', __('task.description')) }}
    </div>
    <div>
        {{
            Form::textarea(
                'description',
                options: [
                    'rows' => 10,
                    'cols' => 50,
                    'class' => 'rounded border-gray-300 w-1/3 h-32',
                ]
            )
        }}
    </div>
    @error('description')
        <div class="text-rose-600">{{ $errors->first('description') }}</div>
    @enderror

    <div class="mt-2">
        {{ Form::label('status_id', __('task.status')) }}
    </div>
    <div>
        {{ 
            Form::select(
                'status_id',
                $taskStatuses,
                selectAttributes: [
                    'class' => 'rounded border-gray-300 w-1/3',
                    'placeholder' => '----------',
                ]
            )
        }}
    </div>
    @error('status_id')
        <div class="text-rose-600">{{ $errors->first('status_id') }}</div>
    @enderror

    <div class="mt-2">
        {{ Form::label('assigned_to_id', __('task.assigned')) }}
    </div>
    <div>
        {{
            Form::select(
                'assigned_to_id',
                $users,
                selectAttributes: [
                    'class' => 'rounded border-gray-300 w-1/3',
                    'placeholder' => '----------',
                ]
            )
        }}
    </div>
    @error('assigned_to_id')
        <div class="text-rose-600">{{ $errors->first('assigned_to_id') }}</div>
    @enderror

    <div class="mt-2">
        {{ Form::label('labels[]', __('main.labels')) }}
    </div>
    <div>
        {{
            Form::select(
                'labels[]',
                $labels,
                selectAttributes: [
                    'class' => 'rounded border-gray-300 w-1/3 h-32',
                    'multiple' => 'multiple',
                ]
            )
        }}
    </div>
    @error('labels')
        <div class="text-rose-600">{{ $errors->first('labels') }}</div>
    @enderror

    @error('labels.*')
        @foreach ($errors->get('labels.*') as [$message]) 
            <div class="text-rose-600">{{ $message }}</div>
        @endforeach
    @enderror

    <div class="mt-2">
        <x-primary-button>{{ $buttonText }}</x-primary-button>
    </div>
</div>
