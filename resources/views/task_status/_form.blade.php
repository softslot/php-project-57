<div class="flex flex-col">
    <div>
        <label for="name">{{ __('task_status.name') }}</label>
    </div>
    <div class="mt-2">
        <input class="rounded border-gray-300 w-1/3"
               name="name"
               type="text"
               id="name"
               value="{{ old('name', $taskStatus->name ?? '') }}">
    </div>
    <div class="mt-2">
        <input class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
               type="submit"
               value="{{ $textButton }}">
    </div>
</div>
