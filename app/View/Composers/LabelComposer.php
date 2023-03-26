<?php

namespace App\View\Composers;

use App\Models\Label;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class LabelComposer
{
    protected Collection $labels;

    public function __construct()
    {
        $this->labels = Label::pluck('name', 'id');
    }

    public function compose(View $view): void
    {
        $view->with('labels', $this->labels);
    }
}
