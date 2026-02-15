<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = DB::table('books')
            ->leftJoin('authors', 'books.author_id', '=', 'authors.id')
            ->leftJoin('categories', 'books.category_id', '=', 'categories.id')
            ->select(
                'books.id',
                'books.title',
                'books.isbn',
                'books.cover_image',
                'authors.name as author_name',
                'categories.name as category_name'
            )
            ->get();

        return view('backend.book-list', ['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = DB::table('categories')->select('id', 'name')->get();
        $authors = DB::table('authors')->select('id', 'name')->get();

        return view('backend.book-create', ['categories' => $categories, 'authors' => $authors]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'required|exists:authors,id',
            'description' => 'nullable|string',
            'published_at' => 'nullable|date',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('covers', 'public');
        }

        DB::table('books')->insert([
            'title' => $validated['title'],
            'isbn' => $validated['isbn'],
            'category_id' => $validated['category_id'],
            'author_id' => $validated['author_id'],
            'description' => $validated['description'] ?? null,
            'published_at' => $validated['published_at'] ?? null,
            'cover_image' => $coverPath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('books.index')->with('success', 'Book created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = DB::table('books')
            ->leftJoin('authors', 'books.author_id', '=', 'authors.id')
            ->leftJoin('categories', 'books.category_id', '=', 'categories.id')
            ->where('books.id', $id)
            ->select('books.*', 'authors.name as author_name', 'authors.bio', 'categories.name as category_name')
            ->first();

        if (!$book) {
            abort(404, 'Book not found');
        }

        return view('backend.book-show', ['book' => $book]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = DB::table('books')->where('id', $id)->first();

        if (!$book) {
            abort(404, 'Book not found');
        }

        $categories = DB::table('categories')->select('id', 'name')->get();
        $authors = DB::table('authors')->select('id', 'name')->get();

        return view('backend.book-edit', [
            'book' => $book,
            'categories' => $categories,
            'authors' => $authors,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $book = DB::table('books')->where('id', $id)->first();

        if (!$book) {
            abort(404, 'Book not found');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn,' . $id,
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'required|exists:authors,id',
            'description' => 'nullable|string',
            'published_at' => 'nullable|date',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $coverPath = $book->cover_image;
        if ($request->hasFile('cover_image')) {
            // Delete old image if it exists
            if ($coverPath) {
                Storage::disk('public')->delete($coverPath);
            }
            $coverPath = $request->file('cover_image')->store('covers', 'public');
        }

        DB::table('books')->where('id', $id)->update([
            'title' => $validated['title'],
            'isbn' => $validated['isbn'],
            'category_id' => $validated['category_id'],
            'author_id' => $validated['author_id'],
            'description' => $validated['description'] ?? null,
            'published_at' => $validated['published_at'] ?? null,
            'cover_image' => $coverPath,
            'updated_at' => now(),
        ]);

        return redirect()->route('books.show', $id)->with('success', 'Book updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = DB::table('books')->where('id', $id)->first();

        if (!$book) {
            abort(404, 'Book not found');
        }

        // Delete cover image if it exists
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        DB::table('books')->where('id', $id)->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted successfully!');
    }
}
