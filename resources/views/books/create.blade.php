@extends('layout')

@section('title', isset($book) ? 'Edit Book' : 'Add New Book')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12">
                <h1>{{ isset($book) ? 'Edit Book' : 'Add New Book' }}</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <h5 class="alert-heading">Please fix the following errors:</h5>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST"
                              action="{{ isset($book) ? route('books.update', $book->id) : route('books.store') }}"
                              enctype="multipart/form-data">
                            @csrf
                            @if (isset($book))
                                @method('PUT')
                            @endif

                            <!-- Title Field -->
                            <div class="mb-3">
                                <label for="title" class="form-label"><strong>Title *</strong></label>
                                <input type="text"
                                       class="form-control @error('title') is-invalid @enderror"
                                       id="title"
                                       name="title"
                                       value="{{ old('title', isset($book) ? $book->title : '') }}"
                                       placeholder="Enter book title"
                                       required>
                                @error('title')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- ISBN Field -->
                            <div class="mb-3">
                                <label for="isbn" class="form-label"><strong>ISBN *</strong></label>
                                <input type="text"
                                       class="form-control @error('isbn') is-invalid @enderror"
                                       id="isbn"
                                       name="isbn"
                                       value="{{ old('isbn', isset($book) ? $book->isbn : '') }}"
                                       placeholder="Enter ISBN number"
                                       required>
                                @error('isbn')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Author Field -->
                            <div class="mb-3">
                                <label for="author_id" class="form-label"><strong>Author *</strong></label>
                                <select class="form-select @error('author_id') is-invalid @enderror"
                                        id="author_id"
                                        name="author_id"
                                        required>
                                    <option value="">-- Select an Author --</option>
                                    @foreach ($authors as $author)
                                        <option value="{{ $author->id }}"
                                                @selected(old('author_id', isset($book) ? $book->author_id : '') == $author->id)>
                                            {{ $author->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('author_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Category Field -->
                            <div class="mb-3">
                                <label for="category_id" class="form-label"><strong>Category *</strong></label>
                                <select class="form-select @error('category_id') is-invalid @enderror"
                                        id="category_id"
                                        name="category_id"
                                        required>
                                    <option value="">-- Select a Category --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                                @selected(old('category_id', isset($book) ? $book->category_id : '') == $category->id)>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Published Date Field -->
                            <div class="mb-3">
                                <label for="published_at" class="form-label"><strong>Published Date</strong></label>
                                <input type="date"
                                       class="form-control @error('published_at') is-invalid @enderror"
                                       id="published_at"
                                       name="published_at"
                                       value="{{ old('published_at', isset($book) ? $book->published_at : '') }}">
                                @error('published_at')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description Field -->
                            <div class="mb-3">
                                <label for="description" class="form-label"><strong>Description</strong></label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description"
                                          name="description"
                                          rows="5"
                                          placeholder="Enter book description">{{ old('description', isset($book) ? $book->description : '') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Cover Image Field -->
                            <div class="mb-3">
                                <label for="cover_image" class="form-label"><strong>Cover Image</strong></label>
                                <input type="file"
                                       class="form-control @error('cover_image') is-invalid @enderror"
                                       id="cover_image"
                                       name="cover_image"
                                       accept="image/jpeg,image/png,image/jpg">
                                <small class="form-text text-muted d-block mt-2">
                                    Allowed formats: JPEG, PNG, JPG | Max size: 2MB
                                </small>
                                @if (isset($book) && $book->cover_image)
                                    <div class="mt-3">
                                        <p><strong>Current Image:</strong></p>
                                        <img src="{{ asset('storage/' . $book->cover_image) }}"
                                             alt="{{ $book->title }}"
                                             style="height: 200px; width: auto; border-radius: 4px;">
                                    </div>
                                @endif
                                @error('cover_image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($book) ? 'Update Book' : 'Add Book' }}
                                </button>
                                <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-body">
                        <h5 class="card-title">Form Tips</h5>
                        <ul class="small">
                            <li><strong>Title</strong> - The name of the book</li>
                            <li><strong>ISBN</strong> - Unique identifier for the book</li>
                            <li><strong>Author</strong> - Select from existing authors</li>
                            <li><strong>Category</strong> - Select from available categories</li>
                            <li><strong>Cover Image</strong> - Upload a book cover (max 2MB)</li>
                        </ul>
                        <hr>
                        <p class="small text-muted">Fields marked with * are required</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
