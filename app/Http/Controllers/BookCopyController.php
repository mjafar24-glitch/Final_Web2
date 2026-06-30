<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookCopyController extends Controller
{
    /**
     * Display a listing of the resource for a specific book.
     */
    public function index(Request $request)
    {
        $book_id = $request->book_id;
        
        if (!$book_id) {
            return redirect()->route('book.index')->withError('Silakan pilih buku terlebih dahulu.');
        }

        $book = Book::findOrFail($book_id);
        $copies = BookCopy::with('location')->where('book_id', $book_id)->latest()->get();

        return view('book_copy.index', [
            'title' => 'Manajemen Eksemplar: ' . $book->title,
            'book' => $book,
            'copies' => $copies,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $book_id = $request->book_id;
        if (!$book_id) {
            return redirect()->route('book.index');
        }

        $book = Book::findOrFail($book_id);

        return view('book_copy.create', [
            'title' => 'Tambah Eksemplar Buku',
            'book' => $book,
            'locations' => Location::orderBy('floor')->orderBy('aisle')->orderBy('shelf_number')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'book_id' => 'required|exists:books,id',
            'location_id' => 'nullable|exists:locations,id',
            'copy_code' => 'nullable|unique:book_copies,copy_code|max:50',
            'status' => 'required|in:available,borrowed,reserved,lost,damaged',
            'condition' => 'nullable|max:100',
        ]);

        if (empty($validate['copy_code'])) {
            $validate['copy_code'] = 'CPY-' . strtoupper(Str::random(8));
        }

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            BookCopy::create($validate);
            \Illuminate\Support\Facades\DB::commit();
            return redirect()->route('book_copy.index', ['book_id' => $validate['book_id']])
                             ->withSuccess('Eksemplar berhasil ditambahkan');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->withError('Gagal menambahkan eksemplar: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BookCopy $bookCopy)
    {
        return view('book_copy.show', [
            'title' => 'Detail Eksemplar',
            'copy' => $bookCopy->load(['book', 'location']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BookCopy $bookCopy)
    {
        return view('book_copy.edit', [
            'title' => 'Edit Eksemplar',
            'copy' => $bookCopy,
            'book' => $bookCopy->book,
            'locations' => Location::orderBy('floor')->orderBy('aisle')->orderBy('shelf_number')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BookCopy $bookCopy)
    {
        $validate = $request->validate([
            'location_id' => 'nullable|exists:locations,id',
            'copy_code' => 'required|unique:book_copies,copy_code,' . $bookCopy->id . '|max:50',
            'status' => 'required|in:available,borrowed,reserved,lost,damaged',
            'condition' => 'nullable|max:100',
        ]);

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            $bookCopy->update($validate);
            \Illuminate\Support\Facades\DB::commit();
            return redirect()->route('book_copy.index', ['book_id' => $bookCopy->book_id])
                             ->withSuccess('Eksemplar berhasil diubah');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->withError('Gagal mengubah eksemplar: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookCopy $bookCopy)
    {
        $book_id = $bookCopy->book_id;
        
        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            $bookCopy->delete();
            \Illuminate\Support\Facades\DB::commit();
            return redirect()->route('book_copy.index', ['book_id' => $book_id])
                             ->withSuccess('Eksemplar berhasil dihapus');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->withError('Gagal menghapus eksemplar: ' . $e->getMessage());
        }
    }
}
