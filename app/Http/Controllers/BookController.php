<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource with Advanced Search.
     */
    public function index(Request $request)
    {
        $query = Book::with('category');

        // Advanced Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('author', 'like', '%' . $search . '%')
                  ->orWhere('isbn', 'like', '%' . $search . '%')
                  ->orWhere('publisher', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('year_published')) {
            $query->where('year_published', $request->year_published);
        }

        $books = $query->latest()->get();

        return view('book.index', [
            'title'      => 'Katalog Buku',
            'books'      => $books,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('book.create', [
            'title'      => 'Tambah Buku',
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'isbn'           => 'required|unique:books,isbn|max:20',
            'title'          => 'required|max:255',
            'author'         => 'required|max:255',
            'publisher'      => 'nullable|max:255',
            'year_published' => 'nullable|integer|min:1000|max:' . date('Y'),
        ]);

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            Book::create($validate);
            \Illuminate\Support\Facades\DB::commit();
            return to_route('book.index')->withSuccess('Buku berhasil ditambahkan');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return to_route('book.create')->withError('Gagal menambahkan buku: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return view('book.show', [
            'title' => 'Detail Buku',
            'book'  => $book->load(['category', 'bookCopies.location', 'bookReviews.member']),
            'members' => \App\Models\Member::where('is_active', true)->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return view('book.edit', [
            'title'      => 'Edit Buku',
            'book'       => $book,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validate = $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'isbn'           => 'required|unique:books,isbn,' . $book->id . '|max:20',
            'title'          => 'required|max:255',
            'author'         => 'required|max:255',
            'publisher'      => 'nullable|max:255',
            'year_published' => 'nullable|integer|min:1000|max:' . date('Y'),
        ]);

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            $book->update($validate);
            \Illuminate\Support\Facades\DB::commit();
            return to_route('book.index')->withSuccess('Data buku berhasil diubah');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return to_route('book.edit', $book)->withError('Gagal mengubah buku: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            $book->delete();
            \Illuminate\Support\Facades\DB::commit();
            return to_route('book.index')->withSuccess('Buku berhasil dihapus');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return to_route('book.index')->withError('Gagal menghapus buku: ' . $e->getMessage());
        }
    }
}
