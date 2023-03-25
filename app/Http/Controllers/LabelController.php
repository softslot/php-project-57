<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLabelRequest;
use App\Http\Requests\UpdateLabelRequest;
use App\Models\Label;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class LabelController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Label::class, 'label');
    }

    public function index(): Response
    {
        $labels = Label::paginate();

        return response()->view('label.index', compact('labels'));
    }

    public function create(): Response
    {
        return response()->view('label.create');
    }

    public function store(StoreLabelRequest $request): RedirectResponse
    {
        Label::create($request->validated());

        flash(__('label.added'))->success();

        return redirect()->route('labels.index');
    }

    public function edit(Label $label): Response
    {
        return response()->view('label.edit', compact('label'));
    }

    public function update(UpdateLabelRequest $request, Label $label): RedirectResponse
    {
        $label->update($request->validated());

        flash(__('label.updated'))->success();

        return redirect()->route('labels.index');
    }

    public function destroy(Label $label): RedirectResponse
    {
        if ($label->tasks->isNotEmpty()) {
            flash(__('label.not_deleted'))->error();
            
            return redirect()
                ->route('labels.index')
                ->withErrors(__('task_status.not_deleted'));
        }

        $label->delete();
        flash(__('label.deleted'))->success();

        return redirect()->route('labels.index');
    }
}
