<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Modules\Event\Models\Event;

class EventDropdown extends Component
{
    public $events;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->events = Event::where('is_active', 1)->orderBy('title')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.event-dropdown');
    }
}
