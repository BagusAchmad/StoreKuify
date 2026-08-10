<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Category::query();

        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $categories = $query->orderBy('name', 'asc')->paginate(10)->withQueryString();

        // -------------------------------------------------------------
        // Summary Cards Metrics:
        // Calculate dynamically from the Product table using configuration.
        // -------------------------------------------------------------
        $totalVariants = \App\Models\Product::count();
        $lowStockCount = \App\Models\Product::where('is_active', true)
            ->where('stock', '<=', config('storekuify.low_stock_threshold', 5))
            ->count();
        $totalEstimatedValue = \App\Models\Product::sum(\DB::raw('cost_price * stock'));

        return view('owner.categories.index', compact(
            'categories',
            'search',
            'totalVariants',
            'lowStockCount',
            'totalEstimatedValue'
        ));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('owner.categories.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        // Trim whitespace before validation
        $request->merge([
            'name' => trim($request->input('name')),
            'description' => trim($request->input('description')),
        ]);

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('categories')
            ],
            'description' => ['nullable', 'string', 'max:255'],
            'is_active' => ['required', 'boolean'],
        ]);

        Category::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('owner.barang')->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category)
    {
        return view('owner.categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category)
    {
        // Trim whitespace before validation
        $request->merge([
            'name' => trim($request->input('name')),
            'description' => trim($request->input('description')),
        ]);

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('categories')->ignore($category->id)
            ],
            'description' => ['nullable', 'string', 'max:255'],
            'is_active' => ['required', 'boolean'],
        ]);

        $category->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('owner.barang')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified category from storage (Hard Delete).
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return redirect()->route('owner.barang')->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('owner.barang')->withErrors([
                'category_delete' => $e->getMessage()
            ]);
        }
    }
}
