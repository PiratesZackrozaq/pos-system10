<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PostResource;

class ProductController extends Controller
{
    // Display a listing of the products
    public function index()
    {
        // Fetch products that belong to the authenticated user
        $products = Auth::user()->products; // Use the relationship in User model
        
        return view('products.index', ['products' => $products]);
    }

    // Show the form for creating a new product
    public function create()
    {
        $categories = Category::all(); // Assuming you have a Category model
        return view('products.create', compact('categories'));
    }

    // Store a newly created product in storage
    public function store(Request $request)
    {
        // Validate inputs
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,category_id', // Validate category_id
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'image' => 'required|image',
            'status' => 'sometimes|boolean'
        ]);

        // Store the uploaded image
        $imagePath = $request->file('image')->store('products', 'public');

        // Create a new product and associate it with the authenticated user
        $product = new Product();
        $product->user_id = Auth::id(); // Associate the product with the authenticated user
        $product->category_id = $request->category_id;
        $product->name = $request->input('name');
        $product->description = $request->input('description', ''); // Default to empty string
        $product->price = $request->input('price');
        $product->quantity = $request->input('quantity');
        $product->image = $imagePath;
        $product->status = $request->input('status', 0); // Default to 0 (Visible)
        $product->save();

        return redirect()->route('products.index')->with('message', 'Product created successfully!');
    }


    // Display the specified product
    public function show($id)
    {
        // Fetch the product belonging to the authenticated user
        $product = Product::where('user_id', Auth::id())->findOrFail($id);

        return view('products.show', ['product' => new PostResource($product)]);
    }

    // Show the form for editing the specified product
    public function edit($id)
    {
        // Fetch the product belonging to the authenticated user
        $product = Product::where('user_id', Auth::id())->findOrFail($id);
        $categories = Category::all();
        
        return view('products.edit', compact('product', 'categories'));
    }

    // Update the specified product in storage
    public function update(Request $request, $id)
    {
        // Fetch the product belonging to the authenticated user
        $product = Product::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,category_id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'image' => 'nullable|image',
            'status' => 'sometimes|boolean'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image && Storage::exists('public/' . $product->image)) {
                Storage::delete('public/' . $product->image);
            }

            // Store new image
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        // Update the product
        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'status' => $request->input('status', 0),
        ]);

        return redirect()->route('products.index')->with('message', 'Product updated successfully!');
    }

    // Remove the specified product from storage
    public function destroy($id)
    {
        // Fetch the product belonging to the authenticated user
        $product = Product::where('user_id', Auth::id())->findOrFail($id);

        // Delete image if exists
        if ($product->image && Storage::exists('public/' . $product->image)) {
            Storage::delete('public/' . $product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('message', 'Product deleted successfully!');
    }

    public function search(Request $request)
    {
        // Get the search query from the request
        $searchTerm = $request->input('search');

        // Search products by name or description
        $products = Product::where('name', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                            ->get();

        // Return the search result view with the products
        return view('search-results', compact('products'));
    }
}
