@extends('layout')

@section('title', $book->title)

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12">
                <a href="{{ route('books.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Books
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                @if ($book->cover_image)
                    <div class="card">
                        <img src="{{ asset('storage/' . $book->cover_image) }}"
                             alt="{{ $book->title }}"
                             class="card-img-top"
                             style="height: 400px; object-fit: cover;">
                    </div>
                @else
                    <div class="card bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                        <div class="text-center text-muted">
                            <i class="bi bi-image" style="font-size: 3rem;"></i>
                            <p>No Cover Image</p>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title">{{ $book->title }}</h1>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><strong>ISBN</strong></label>
                                    <p><code>{{ $book->isbn }}</code></p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><strong>Author</strong></label>
                                    <p>{{ $book->author_name ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><strong>Category</strong></label>
                                    <p>
                                        <span class="badge bg-info">{{ $book->category_name ?? 'N/A' }}</span>
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><strong>Published Date</strong></label>
                                    <p>{{ $book->published_at ? \Carbon\Carbon::parse($book->published_at)->format('d M Y') : 'Not specified' }}</p>
                                </div>
                            </div>
                        </div>

                        @if ($book->bio)
                            <div class="mb-3">
                                <label class="form-label"><strong>Author Bio</strong></label>
                                <p class="text-muted">{{ $book->bio }}</p>
                            </div>
                        @endif

                        @if ($book->description)
                            <div class="mb-4">
                                <label class="form-label"><strong>Description</strong></label>
                                <p>{{ $book->description }}</p>
                            </div>
                        @endif

                        <div class="btn-group" role="group">
                            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form method="POST" action="{{ route('books.destroy', $book->id) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this book?')">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
