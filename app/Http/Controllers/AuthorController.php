<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = DB::table('authors')
            ->leftJoin('books', 'authors.id', '=', 'books.author_id')
            ->select('authors.*', DB::raw('COUNT(books.id) as books_count'))
            ->groupBy('authors.id', 'authors.name', 'authors.is_active', 'authors.bio', 'authors.created_at', 'authors.updated_at')
            ->paginate(15);
        return view('backend.author-list', ['authors' => $authors]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.author-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
        ]);

        DB::table('authors')->insert([
            'name' => $validated['name'],
            'bio' => $validated['bio'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('authors.index')->with('success', 'Author created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $author = DB::table('authors')->where('id', $id)->first();

        if (!$author) {
            abort(404, 'Author not found');
        }

        $books = DB::table('books')
            ->where('author_id', $id)
            ->leftJoin('categories', 'books.category_id', '=', 'categories.id')
            ->select('books.*', 'categories.name as category_name')
            ->get();

        return view('backend.author-show', ['author' => $author, 'books' => $books]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $author = DB::table('authors')->where('id', $id)->first();

        if (!$author) {
            abort(404, 'Author not found');
        }

        return view('backend.author-edit', ['author' => $author]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
        ]);

        DB::table('authors')
            ->where('id', $id)
            ->update([
                'name' => $validated['name'],
                'bio' => $validated['bio'] ?? null,
                'updated_at' => now(),
            ]);

        return redirect()->route('authors.show', $id)->with('success', 'Author updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $author = DB::table('authors')->where('id', $id)->first();

        if (!$author) {
            abort(404, 'Author not found');
        }

        // Check if author has books
        $bookCount = DB::table('books')->where('author_id', $id)->count();
        if ($bookCount > 0) {
            return redirect()->route('authors.index')->with('error', 'Cannot delete author with existing books!');
        }

        DB::table('authors')->where('id', $id)->delete();

        return redirect()->route('authors.index')->with('success', 'Author deleted successfully!');
    }

    /**
     * Toggle the active status of an author.
     */
    public function toggleStatus(string $id)
    {
        $author = DB::table('authors')->where('id', $id)->first();

        if (!$author) {
            abort(404, 'Author not found');
        }

        DB::table('authors')
            ->where('id', $id)
            ->update([
                'is_active' => !$author->is_active,
                'updated_at' => now(),
            ]);

        $status = !$author->is_active ? 'activated' : 'deactivated';
        return redirect()->route('authors.index')->with('success', "Author {$status} successfully!");
    }
}
