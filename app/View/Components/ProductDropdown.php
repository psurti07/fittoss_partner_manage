<?php

namespace App\View\Components;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProductDropdown extends Component
{
    public $products;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->products = Product::select('id', 'product_title')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.product-dropdown');
    }
}
