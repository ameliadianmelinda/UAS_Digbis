<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('events')
            ->when($request->filled('search'), fn ($query) => $query->where('name', 'like', '%' . $request->query('search') . '%'))
            ->latest()->paginate(10)->withQueryString();

        return view('superadmin.categories.index', compact('categories'));
    }

    public function create() { return view('superadmin.categories.create'); }

    public function store(Request $request)
    {
        Category::create($request->validate(['name' => ['required', 'string', 'max:255']]));
        return redirect()->route('superadmin.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category) { return view('superadmin.categories.edit', compact('category')); }

    public function update(Request $request, Category $category)
    {
        $category->update($request->validate(['name' => ['required', 'string', 'max:255']]));
        return redirect()->route('superadmin.categories.index')->with('success', 'Kategori berhasil diubah.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}