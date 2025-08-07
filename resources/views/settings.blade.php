<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Settings</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Lucide Icons -->
  <script type="module">
    import { createIcons, icons } from "https://unpkg.com/lucide@latest/dist/esm/lucide.js";
    window.addEventListener("DOMContentLoaded", () => createIcons({ icons }));
  </script>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen p-6">

  <div class="flex-1 p-4 sm:p-8 max-w-3xl mx-auto w-full">
    <div class="bg-gray-100 p-6 rounded-2xl shadow-xl space-y-6 mt-4">
      <h2 class="text-xl font-semibold text-gray-800 mb-2">Settings</h2>

      <form action="{{ route('logout') }}" method="POST" class="space-y-2">
        @csrf
        <button type="submit"
          class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-xl transition duration-200">
          Logout
        </button>
      </form>
    </div>
  </div>

  <nav class="fixed bottom-0 left-0 right-0 bg-white border-t shadow-md flex justify-around py-2 z-10">
    <a href="{{ route('home') }}" class="flex flex-col items-center text-gray-700 text-sm" aria-label="Map">
      <i data-lucide="map" class="w-6 h-6 mb-1"></i>
      <span>Map</span>
    </a>
    <a href="{{ route('washadd') }}" class="flex flex-col items-center text-gray-700 text-sm" aria-label="Add">
      <i data-lucide="plus-circle" class="w-6 h-6 mb-1"></i>
      <span>Add</span>
    </a>
    <a href="{{ route('settings') }}" class="flex flex-col items-center text-gray-700 text-sm" aria-label="Settings">
      <i data-lucide="settings" class="w-6 h-6 mb-1"></i>
      <span>Settings</span>
    </a>
  </nav>

</body>

</html>