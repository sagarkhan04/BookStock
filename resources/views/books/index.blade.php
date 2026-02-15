@extends('layout')

@section('title', 'All Books')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-8">
                <h1>📚 All Books</h1>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('books.create') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-plus"></i> Add New Book
                </a>
            </div>
        </div>

        @if ($books->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Cover</th>
                            <th>Title</th>
                            <th>ISBN</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($books as $book)
                            <tr>
                                <td>
                                    @if ($book->cover_image)
                                        <img src="{{ asset('storage/' . $book->cover_image) }}"
                                             alt="{{ $book->title }}"
                                             style="height: 50px; width: auto; border-radius: 4px;">
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $book->title }}</strong>
                                </td>
                                <td>
                                    <code>{{ $book->isbn }}</code>
                                </td>
                                <td>
                                    {{ $book->author_name ?? 'N/A' }}
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $book->category_name ?? 'N/A' }}</span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('books.show', $book->id) }}"
                                       class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('books.edit', $book->id) }}"
                                       class="btn btn-sm btn-warning">Edit</a>
                                    <form method="POST" action="{{ route('books.destroy', $book->id) }}"
                                          style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this book?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info text-center py-5">
                <h5>No books found</h5>
                <p>Start by adding your first book!</p>
                <a href="{{ route('books.create') }}" class="btn btn-primary">Add First Book</a>
            </div>
        @endif
    </div>
@endsection
