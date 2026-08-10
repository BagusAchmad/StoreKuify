<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class KasirBarangController extends Controller
{
    /**
     * Display a read-only listing of categories and product statistics for Cashier.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Category::query();

        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $categories = $query->orderBy('name', 'asc')->paginate(10)->withQueryString();

        $totalCategories = Category::count();
        $totalProducts = Product::count();
        $lowStockCount = Product::where('is_active', true)
            ->where('stock', '<=', 5)
            ->count();

        return view('kasir.barang.index', compact(
            'categories',
            'totalCategories',
            'totalProducts',
            'lowStockCount',
            'search'
        ));
    }

    /**
     * Display read-only category product list for Cashier.
     */
    public function show(Request $request, Category $category)
    {
        $search = $request->input('search');

        $query = $category->products();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('sku', 'like', '%' . $search . '%');
            });
        }

        $products = $query->orderBy('name', 'asc')->paginate(10)->withQueryString();

        $totalProducts = $category->products()->count();
        $totalStock = $category->products()->sum('stock');

        return view('kasir.barang.show', compact(
            'category',
            'products',
            'totalProducts',
            'totalStock',
            'search'
        ));
    }
}
