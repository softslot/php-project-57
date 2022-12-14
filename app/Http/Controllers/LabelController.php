<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLabelRequest;
use App\Http\Requests\UpdateLabelRequest;
use App\Models\Label;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class LabelController extends Controller
{
    public function index(): Response
    {
        $labels = Label::query()
            ->select(['*'])
            ->paginate();

        return response()->view('label.index', compact('labels'));
    }

    public function create(): Response
    {
        return response()->view('label.create');
    }

    public function store(StoreLabelRequest $request): RedirectResponse
    {
        Label::query()->create($request->validated());

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

    public function destroy(Label $label)
    {
        $deleted = $label->delete();
        if ($deleted) {
            flash(__('label.deleted'))->success();
        } else {
            flash(__('label.not_deleted'))->error();
        }
        
        return redirect()->back();
    }
}
