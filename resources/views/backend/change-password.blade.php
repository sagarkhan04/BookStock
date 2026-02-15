<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Change Password | Interactive Cares</title>
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
            animation: {
              fadeIn: "fadeIn 0.5s ease-in forwards",
              slideIn: "slideIn 0.3s ease-out forwards",
            },
            keyframes: {
              fadeIn: {
                from: { opacity: 0, transform: "translateY(10px)" },
                to: { opacity: 1, transform: "translateY(0)" },
              },
              slideIn: {
                from: { opacity: 0, transform: "translateX(-10px)" },
                to: { opacity: 1, transform: "translateX(0)" },
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
      .glass {
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
      }
      .dashboard-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
      }
      @media (min-width: 768px) {
        .dashboard-grid {
          grid-template-columns: 1fr 1fr;
        }
      }
      @media (min-width: 1024px) {
        .dashboard-grid {
          grid-template-columns: 1fr 1fr 1fr;
        }
      }
      .progress-bar {
        height: 0.5rem;
        border-radius: 9999px;
        background-color: #e5e7eb;
        overflow: hidden;
      }
      .progress-fill {
        height: 100%;
        border-radius: 9999px;
        background: linear-gradient(to right, #4f46e5, #7e22ce);
        transition: width 0.5s ease;
      }
      .sidebar-link {
        transition: all 0.2s ease;
      }
      .sidebar-link:hover,
      .sidebar-link.active {
        background-color: #f3f4f6;
        border-left: 4px solid #4f46e5;
      }
    </style>
  </head>
  <body class="bg-gray-50 min-h-screen">
    <!-- Dashboard Container -->
    <div class="flex flex-col lg:flex-row min-h-screen">
      @include('components.sidebar')

      <!-- Main Content -->
      <main class="flex-1 p-6 lg:p-8">
        <!-- Header -->
        <div
          class="flex flex-col md:flex-row md:items-center justify-between mb-8"
        >
          <div>
            <h2 class="text-2xl font-bold text-gray-800">Change Password</h2>
            <p class="text-gray-600">Ensure your account is secure</p>
          </div>
          <div class="flex items-center space-x-4 mt-4 md:mt-0">
            <button
              onclick="window.location.href = 'login.html'"
              class="flex items-center space-x-2 px-4 py-2 bg-white border border-gray-200 rounded-lg text-gray-600 hover:text-indigo-600 hover:border-indigo-600 transition-all duration-200"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-5 h-5"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"
                />
              </svg>
              <span>Logout</span>
            </button>
          </div>
        </div>

        <!-- Profile Section -->
        <div class="max-w-4xl">
          <div class="bg-white rounded-xl shadow overflow-hidden">
            <div
              class="bg-gradient-to-r from-indigo-500 to-purple-600 h-2"
            ></div>
            <div class="p-6">
              @if ($errors->any())
              <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <p class="text-red-800 font-semibold mb-2">Please fix the following errors:</p>
                <ul class="list-disc list-inside space-y-1">
                  @foreach ($errors->all() as $error)
                  <li class="text-red-700 text-sm">{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              @endif

              @if (session('success'))
              <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-green-800 font-semibold">{{ session('success') }}</p>
              </div>
              @endif

              <form action="{{ route('update-password') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 gap-6">
                  <div>
                    <label
                      class="block text-sm font-semibold text-gray-700 mb-2"
                      >Current Password</label
                    >
                    <div class="relative">
                      <div
                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
                      >
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke-width="1.5"
                          stroke="currentColor"
                          class="w-5 h-5 text-gray-400"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"
                          />
                        </svg>
                      </div>
                      <input
                        type="password"
                        name="current_password"
                        class="w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 {{ $errors->has('current_password') ? 'border-red-500' : '' }}"
                        placeholder="••••••••"
                      />
                    </div>
                  </div>

                  <div>
                    <label
                      class="block text-sm font-semibold text-gray-700 mb-2"
                      >New Password</label
                    >
                    <div class="relative">
                      <div
                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
                      >
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke-width="1.5"
                          stroke="currentColor"
                          class="w-5 h-5 text-gray-400"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"
                          />
                        </svg>
                      </div>
                      <input
                        type="password"
                        name="password"
                        class="w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 {{ $errors->has('password') ? 'border-red-500' : '' }}"
                        placeholder="••••••••"
                      />
                    </div>
                  </div>

                  <div>
                    <label
                      class="block text-sm font-semibold text-gray-700 mb-2"
                      >Confirm New Password</label
                    >
                    <div class="relative">
                      <div
                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
                      >
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke-width="1.5"
                          stroke="currentColor"
                          class="w-5 h-5 text-gray-400"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"
                          />
                        </svg>
                      </div>
                      <input
                        type="password"
                        name="password_confirmation"
                        class="w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300"
                        placeholder="••••••••"
                      />
                    </div>
                  </div>
                </div>

                <div class="flex justify-end pt-4">
                  <button
                    type="submit"
                    class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium rounded-xl hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                  >
                    Update Password
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </main>
    </div>
  </body>
</html>
