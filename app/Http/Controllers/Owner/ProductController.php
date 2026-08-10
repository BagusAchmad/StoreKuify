<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display the category details and all products belonging to it.
     */
    public function showCategoryDetails(Category $category, Request $request)
    {
        // Category slug is bound via Laravel model binding as $category
        $search = $request->input('search');

        $query = $category->products();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('sku', 'like', '%' . $search . '%');
            });
        }

        $products = $query->orderBy('name', 'asc')->paginate(10)->withQueryString();

        // -------------------------------------------------------------
        // Summary Cards Metrics:
        // Calculated dynamically based only on this selected category.
        // -------------------------------------------------------------
        $totalVariants = $category->products()->count();
        
        $threshold = config('storekuify.low_stock_threshold', 5);
        $lowStockCount = $category->products()
            ->where('is_active', true)
            ->where('stock', '<=', $threshold)
            ->count();
            
        $totalEstimatedValue = $category->products()->sum(\DB::raw('cost_price * stock'));

        return view('owner.categories.detail', compact(
            'category',
            'products',
            'search',
            'totalVariants',
            'lowStockCount',
            'totalEstimatedValue'
        ));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(Category $category)
    {
        return view('owner.products.create', compact('category'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request, Category $category)
    {
        // Trim whitespace
        $request->merge([
            'name' => trim($request->input('name')),
        ]);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'stock' => ['required', 'integer', 'min:0'],
            'cost_price' => ['required', 'numeric', 'min:0'],
            'selling_price' => ['required', 'numeric', 'min:0'],
            'is_active' => ['required', 'boolean'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,webp,jpg', 'max:2048'], // Max 2MB
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($request->input('name')) . '.' . $file->getClientOriginalExtension();
            
            // Move file directly to public/uploads/products/ for robust XAMPP display
            $file->move(public_path('uploads/products'), $filename);
            $imagePath = 'uploads/products/' . $filename;
        }

        $category->products()->create([
            'name' => $request->input('name'),
            'stock' => $request->input('stock'),
            'cost_price' => $request->input('cost_price'),
            'selling_price' => $request->input('selling_price'),
            'is_active' => $request->boolean('is_active'),
            'image' => $imagePath,
        ]);

        return redirect()->route('owner.barang.show', $category->slug)->with('success', 'Barang berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Category $category, Product $product)
    {
        // Explicit ownership check
        if ($product->category_id !== $category->id) {
            abort(403, 'Produk tidak terdaftar di kategori ini.');
        }

        return view('owner.products.edit', compact('category', 'product'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Category $category, Product $product)
    {
        // Explicit ownership check
        if ($product->category_id !== $category->id) {
            abort(403, 'Produk tidak terdaftar di kategori ini.');
        }

        // Trim whitespace
        $request->merge([
            'name' => trim($request->input('name')),
        ]);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'stock' => ['required', 'integer', 'min:0'],
            'cost_price' => ['required', 'numeric', 'min:0'],
            'selling_price' => ['required', 'numeric', 'min:0'],
            'is_active' => ['required', 'boolean'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,webp,jpg', 'max:2048'], // Max 2MB
        ]);

        $imagePath = $product->image;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($request->input('name')) . '.' . $file->getClientOriginalExtension();
            
            // 1. Store the new image successfully first
            $file->move(public_path('uploads/products'), $filename);
            
            // 2. Remove the old image file if it exists
            if (!empty($product->image)) {
                $oldPath = public_path($product->image);
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $imagePath = 'uploads/products/' . $filename;
        }

        $product->update([
            'name' => $request->input('name'),
            'stock' => $request->input('stock'),
            'cost_price' => $request->input('cost_price'),
            'selling_price' => $request->input('selling_price'),
            'is_active' => $request->boolean('is_active'),
            'image' => $imagePath,
        ]);

        return redirect()->route('owner.barang.show', $category->slug)->with('success', 'Barang berhasil diperbarui.');
    }

    /**
     * Soft delete the product.
     */
    public function destroy(Category $category, Product $product)
    {
        // Explicit ownership check
        if ($product->category_id !== $category->id) {
            abort(403, 'Produk tidak terdaftar di kategori ini.');
        }

        // Soft delete the product (Do NOT delete image, as it might be restored later)
        $product->delete();

        return redirect()->route('owner.barang.show', $category->slug)->with('success', 'Barang berhasil diarsipkan.');
    }
}
