<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = DB::table('categories')
            ->leftJoin('books', 'categories.id', '=', 'books.category_id')
            ->select('categories.*', DB::raw('COUNT(books.id) as books_count'))
            ->groupBy('categories.id', 'categories.name', 'categories.description', 'categories.is_active', 'categories.created_at', 'categories.updated_at')
            ->paginate(15);
        return view('backend.category-list', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.category-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:1000',
        ]);

        DB::table('categories')->insert([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = DB::table('categories')->where('id', $id)->first();

        if (!$category) {
            abort(404, 'Category not found');
        }

        $books = DB::table('books')
            ->where('category_id', $id)
            ->leftJoin('authors', 'books.author_id', '=', 'authors.id')
            ->select('books.*', 'authors.name as author_name')
            ->get();

        return view('backend.category-show', ['category' => $category, 'books' => $books]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = DB::table('categories')->where('id', $id)->first();

        if (!$category) {
            abort(404, 'Category not found');
        }

        return view('backend.category-edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string|max:1000',
        ]);

        DB::table('categories')
            ->where('id', $id)
            ->update([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'updated_at' => now(),
            ]);

        return redirect()->route('categories.show', $id)->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = DB::table('categories')->where('id', $id)->first();

        if (!$category) {
            abort(404, 'Category not found');
        }

        // Check if category has books
        $bookCount = DB::table('books')->where('category_id', $id)->count();
        if ($bookCount > 0) {
            return redirect()->route('categories.index')->with('error', 'Cannot delete category with existing books!');
        }

        DB::table('categories')->where('id', $id)->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }

    /**
     * Toggle the active status of a category.
     */
    public function toggleStatus(string $id)
    {
        $category = DB::table('categories')->where('id', $id)->first();

        if (!$category) {
            abort(404, 'Category not found');
        }

        DB::table('categories')
            ->where('id', $id)
            ->update([
                'is_active' => !$category->is_active,
                'updated_at' => now(),
            ]);

        $status = !$category->is_active ? 'activated' : 'deactivated';
        return redirect()->route('categories.index')->with('success', "Category {$status} successfully!");
    }
}
