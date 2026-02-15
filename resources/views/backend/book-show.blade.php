<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $book->title }} | Interactive Cares</title>
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
              <a href="{{ route('books.index') }}" class="text-gray-500 hover:text-gray-700 lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
              </a>
              <div>
                <h1 class="text-xl font-bold text-gray-800">{{ $book->title }}</h1>
                <p class="text-sm text-gray-500">Book Details</p>
              </div>
            </div>

            <div class="flex items-center space-x-3">
              <a href="{{ route('books.edit', $book->id) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                Edit
              </a>
              <form method="POST" action="{{ route('books.destroy', $book->id) }}" style="display: inline;" onsubmit="return confirm('Are you sure?')">
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

              <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Book Cover -->
                <div class="md:col-span-1">
                  @if ($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full rounded-lg shadow-lg object-cover" />
                  @else
                    <div class="w-full bg-gray-200 rounded-lg flex items-center justify-center" style="aspect-ratio: 3/4;">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                      </svg>
                    </div>
                  @endif
                </div>

                <!-- Book Details -->
                <div class="md:col-span-2 space-y-6">
                  <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ $book->title }}</h2>
                    <div class="space-y-2">
                      <p class="text-gray-600"><span class="font-semibold">ISBN:</span> <code class="bg-gray-100 px-2 py-1 rounded">{{ $book->isbn }}</code></p>
                      <p class="text-gray-600"><span class="font-semibold">Author:</span> {{ $book->author_name ?? 'N/A' }}</p>
                      <p class="text-gray-600"><span class="font-semibold">Category:</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                          {{ $book->category_name ?? 'N/A' }}
                        </span>
                      </p>
                      @if ($book->published_at)
                        <p class="text-gray-600"><span class="font-semibold">Published:</span> {{ \Carbon\Carbon::parse($book->published_at)->format('F d, Y') }}</p>
                      @endif
                    </div>
                  </div>

                  @if ($book->bio)
                    <div>
                      <h3 class="text-lg font-semibold text-gray-800 mb-2">Author Bio</h3>
                      <p class="text-gray-600">{{ $book->bio }}</p>
                    </div>
                  @endif
                </div>
              </div>

              @if ($book->description)
                <div class="border-t pt-6">
                  <h3 class="text-lg font-semibold text-gray-800 mb-3">Description</h3>
                  <p class="text-gray-600 leading-relaxed">{{ $book->description }}</p>
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
