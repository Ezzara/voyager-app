<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    // List all books
    public function index()
    {
        return Book::all();
    }

    // Store a new book
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'published_date' => 'required|date',
        ]);

        $book = Book::create($validated);

        return response()->json($book, 201);
    }

    // Show a single book
    public function show($id)
    {
        return Book::findOrFail($id);
    }

    // Update a book
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string',
            'author' => 'sometimes|required|string',
            'published_date' => 'sometimes|required|date',
        ]);

        $book->update($validated);

        return response()->json($book);
    }

    // Delete a book
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return response()->json(null, 204);
    }
}
