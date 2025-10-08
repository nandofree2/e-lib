<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'cover' => 'nullable|image',
            'stock' => 'required|integer',
            'status_book' => 'required|in:available,unavailable',
            'synopsis' => 'nullable|string',
        ]);

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        Book::create($data);
        return redirect()->route('books.index');
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        return view('books.create', compact('book')); // optional separate edit view
    }

    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'cover' => 'nullable|image',
            'stock' => 'required|integer',
            'status_book' => 'required|in:available,unavailable',
            'synopsis' => 'nullable|string',
        ]);

        if ($request->hasFile('cover')) {
            if ($book->cover) {
                Storage::disk('public')->delete($book->cover);
            }
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $book->update($data);
        return redirect()->route('books.index');
    }

    public function destroy(Book $book)
    {
        if ($book->cover) {
            Storage::disk('public')->delete($book->cover);
        }
        $book->delete();
        return redirect()->route('books.index');
    }
}

