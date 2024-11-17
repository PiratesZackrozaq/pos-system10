<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Display a listing of the categories
    public function index()
    {
            // Fetch categories that belong to the authenticated user
        $categories = Auth::user()->categories;
        
        return view('categories.index', compact('categories'));
    }

    public function fetchCategoriesForWelcome()
    {
        // Fetch all categories
        $categories = Category::with('products')->get();

        // Fetch all products for the "All Products" tab
        $allProducts = Product::all();

        return view('welcome', [
            'categoriesForWelcome' => $categories,
            'allProducts' => $allProducts, // For the "All Products" tab
        ]);
    }

    // Show the form for creating a new category
    public function create()
    {
        return view('categories.create');
    }

    // Store a newly created category in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|string',
            'status' => 'boolean',
        ]);

        $category = new Category;
        $category->user_id = Auth::id(); // Associate category with the authenticated user
        $category->name = $request->name;
        $category->description = $request->description;
        $category->status = $request->status ?? 0; // Default to 0 (Visible)
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    // Display a specific category by ID
    public function show($id)
    {
        // Fetch only the category that belongs to the authenticated user
        $category = Auth::user()->categories()->findOrFail($id);
        return view('categories.show', compact('category'));
    }

    // Show the form for editing a specific category
    public function edit($id)
    {
        // Fetch only the category that belongs to the authenticated user
        $category = Auth::user()->categories()->findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    // Update the specified category in the database
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|string',
            'status' => 'boolean',
        ]);

        // Fetch only the category that belongs to the authenticated user
        $category = Auth::user()->categories()->findOrFail($id);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->status = $request->status ?? 0;
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    // Remove the specified category from the database
    public function destroy($id)
    {
        // Fetch only the category that belongs to the authenticated user
        $category = Auth::user()->categories()->findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
