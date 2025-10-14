<?php

namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status_book');

        $books = Book::when($status, function ($query, $status) {
                return $query->where('status_book', $status);
            })
            ->paginate(8);

        return view('welcome', compact('books', 'status'));
    }
}
