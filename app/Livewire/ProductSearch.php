<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductSearch extends Component
{
    public $query = ''; // Search input
    public $products = []; // Store search results

    // Method triggered on input change, fetch matching products
    public function updatedQuery()
    {
        $this->products = Product::where('name', 'like', '%' . $this->query . '%')
            ->orWhere('description', 'like', '%' . $this->query . '%')
            ->get()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.product-search');
    }
}
