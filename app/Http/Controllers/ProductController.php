<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query();

        // Search
        if ($request->has('search')) {
            $products->where('name', 'like', '%' . $request->search . '%')
                     ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Filter by price range
        if ($request->has('min_price') && $request->has('max_price')) {
            $products->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        // Sort
        if ($request->has('sort_by')) {
            $sortBy = $request->sort_by == 'name' ? 'name' : 'price';
            $sortDirection = $request->has('sort_dir') && $request->sort_dir == 'desc' ? 'desc' : 'asc';
            $products->orderBy($sortBy, $sortDirection);
        }

        $products = $products->paginate(20);
        return view('products.list', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        Product::create($validatedData);
        return redirect()->route('products')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.form', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product->update($validatedData);
        return redirect()->route('products')->with('success', 'Product updated successfully.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}