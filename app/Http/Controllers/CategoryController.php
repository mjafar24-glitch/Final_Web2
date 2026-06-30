<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('category.index', [
            'title' => 'Kategori Buku',
            'categories' => Category::withCount('books')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create', [
            'title' => 'Tambah Kategori',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|unique:categories,name|max:100',
        ]);

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            Category::create($validate);
            \Illuminate\Support\Facades\DB::commit();
            return to_route('category.index')->withSuccess('Kategori berhasil ditambahkan');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return to_route('category.create')->withError('Gagal menambahkan kategori: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('category.show', [
            'title' => 'Detail Kategori',
            'category' => $category->load('books'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('category.edit', [
            'title' => 'Edit Kategori',
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validate = $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id . '|max:100',
        ]);

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            $category->update($validate);
            \Illuminate\Support\Facades\DB::commit();
            return to_route('category.index')->withSuccess('Kategori berhasil diubah');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return to_route('category.edit', $category)->withError('Gagal mengubah kategori: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            $category->delete();
            \Illuminate\Support\Facades\DB::commit();
            return to_route('category.index')->withSuccess('Kategori berhasil dihapus');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return to_route('category.index')->withError('Gagal menghapus kategori: ' . $e->getMessage());
        }
    }
}
