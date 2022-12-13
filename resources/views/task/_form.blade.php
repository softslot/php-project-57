@csrf

<div class="flex flex-col">
    <div>
        <label for="name">{{ __('task.name') }}</label>
    </div>
    <div class="mt-2">
        <input class="rounded border-gray-300 w-1/3" name="name" type="text" id="name" value="{{ old('name', $task->name ?? '') }}">
    </div>

    <div class="mt-2">
        <label for="description">{{ __('task.description') }}</label>
    </div>
    <div>
        <textarea class="rounded border-gray-300 w-1/3 h-32"
                  cols="50"
                  rows="10"
                  name="description"
                  id="description">{{ old('decrtiption', $task->description ?? '') }}</textarea>
    </div>

    <div class="mt-2">
        <label for="status_id">{{ __('task.status') }}</label>
    </div>
    <div>
        <select class="rounded border-gray-300 w-1/3" id="status_id" name="status_id">
            <option {{ is_null($task->status) ? 'selected="selected"' : '' }} value="">----------</option>
            @foreach ($taskStatuses as $taskStatus)
            <option {{ $task->status->id === $taskStatus->id ? 'selected="selected"' : '' }} value="{{ $taskStatus->id }}">{{ $taskStatus->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mt-2">
        <label for="assigned_to_id">{{ __('task.assigned') }}</label>
    </div>
    <div>
        <select class="rounded border-gray-300 w-1/3" id="assigned_to_id" name="assigned_to_id">
            <option selected="selected" value="">----------</option>
            @foreach ($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mt-2">
        <label for="labels">{{ __('main.tags') }}</label>
    </div>
    <div>
        <select multiple="multiple" name="labels[]" class="rounded border-gray-300 w-1/3 h-32" id="labels">
            <option selected="selected" value=""></option>
            <option value="1">ошибка</option>
            <option value="2">документация</option>
            <option value="3">дубликат</option>
            <option value="4">доработка</option>
        </select>
    </div>

    <div class="mt-2">
        <x-primary-button>{{ $buttonText }}</x-primary-button>
    </div>
</div>
