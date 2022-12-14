<?php

namespace App\View\Composers;

use App\Models\Label;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class LabelComposer
{
    protected Collection $labels;

    public function __construct()
    {
        $this->labels = Label::all();
    }

    public function compose(View $view): void
    {
        $view->with('labels', $this->labels);
    }
}
