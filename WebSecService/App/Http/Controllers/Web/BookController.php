<?php

namespace App\Http\Controllers\Web;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Only authenticated users can access these methods
    }

    // Show the form to add a book
    public function create()
    {
        return view('books.create');
    }

    // Store a new book
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'published_year' => 'required|integer|digits:4',
        ]);

        Book::create($request->all());

        return redirect()->route('books.index')->with('success', 'Book added successfully!');
    }

    // Show the list of books
    public function index()
    {
        $books = Book::all();
        return view('books.index', compact('books'));
    }
}

?>