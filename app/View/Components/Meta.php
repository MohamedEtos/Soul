<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Meta extends Component
{
    public string $title;
    public string $description;
    public ?string $image;
    public ?string $url;

    public function __construct(
        string $title = '',
        string $description = '',
        string $image = null,
        string $url = null
    ) {
        $this->title = $title ?: config('app.name');
        $this->description = $description ?: 'وصف افتراضي للموقع';
        $this->image = $image ?: asset('store/images/icons/favicon.png');
        $this->url = $url ?: url()->current();
    }

    public function render()
    {
        return view('store.layouts.meta');
    }
}
