<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $category->name }} | Interactive Cares</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              indigo: {
                50: "#eef2ff",
                100: "#e0e7ff",
                500: "#6366f1",
                600: "#4f46e5",
                700: "#4338ca",
              },
              purple: {
                50: "#faf5ff",
                500: "#a855f7",
                600: "#9333ea",
                700: "#7e22ce",
              },
            },
          },
        },
      };
    </script>
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap");
      body {
        font-family: "Inter", sans-serif;
      }
      .sidebar-link {
        transition: all 0.2s ease;
      }
      .sidebar-link:hover,
      .sidebar-link.active {
        background-color: #f3f4f6;
        border-left: 4px solid #4f46e5;
      }
      .dropdown-menu {
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.2s ease;
      }
      .dropdown-menu.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
      }
    </style>
  </head>
  <body class="bg-gray-50 min-h-screen">
    <!-- Dashboard Container -->
    <div class="flex flex-col lg:flex-row min-h-screen">
      @include('components.sidebar')

      <!-- Main Content -->
      <main class="flex-1 flex flex-col">
        <!-- Top Header -->
        <header class="bg-white shadow-sm sticky top-0 z-20">
          <div class="px-6 lg:px-8 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-4">
              <a href="{{ route('categories.index') }}" class="text-gray-500 hover:text-gray-700 lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
              </a>
              <div>
                <h1 class="text-xl font-bold text-gray-800">{{ $category->name }}</h1>
                <p class="text-sm text-gray-500">Category Details</p>
              </div>
            </div>

            <div class="flex items-center space-x-3">
              <a href="{{ route('categories.edit', $category->id) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                Edit
              </a>
              <form method="POST" action="{{ route('categories.destroy', $category->id) }}" style="display: inline;" onsubmit="return confirm('Are you sure?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                  Delete
                </button>
              </form>
            </div>
          </div>
        </header>

        <!-- Content -->
        <div class="flex-1 p-6 lg:p-8">
          <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-2"></div>
            <div class="p-6">
              <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $category->name }}</h2>
                <p class="text-gray-600">Created: {{ \Carbon\Carbon::parse($category->created_at)->format('M d, Y') }}</p>
              </div>

              <h3 class="text-lg font-semibold text-gray-900 mb-4">Books in this Category</h3>
              @if ($books->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                  @foreach ($books as $book)
                    <a href="{{ route('books.show', $book->id) }}" class="group border border-gray-200 rounded-lg p-4 hover:shadow-md hover:border-indigo-300 transition-all">
                      <div class="text-sm text-gray-500 mb-2">{{ $book->author_name ?? 'Unknown Author' }}</div>
                      <h4 class="font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $book->title }}</h4>
                      <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ Str::limit($book->description, 100) }}</p>
                    </a>
                  @endforeach
                </div>
              @else
                <div class="text-center py-8 text-gray-500">
                  <p>No books found in this category.</p>
                  <a href="{{ route('books.create') }}" class="text-indigo-600 hover:text-indigo-700 mt-2 inline-block">Create a new book</a>
                </div>
              @endif
            </div>
          </div>
        </div>
      </main>
    </div>

    <script>
      // Dropdown functionality
      function toggleDropdown() {
        const dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('show');
      }

      // Close dropdown when clicking outside
      document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('userDropdown');
        const button = document.getElementById('userMenuButton');
        if (dropdown && button && !dropdown.contains(event.target) && !button.contains(event.target)) {
          dropdown.classList.remove('show');
        }
      });
    </script>
  </body>
</html>
