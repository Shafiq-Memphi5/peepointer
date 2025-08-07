<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Pending Toilets - Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Lucide Icons -->
  <script type="module">
    import { createIcons, icons } from "https://unpkg.com/lucide@latest/dist/esm/lucide.js";
    window.addEventListener("DOMContentLoaded", () => createIcons({ icons }));
  </script>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>

  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>

<body class="bg-gray-100 min-h-screen text-gray-800">
  <div class="max-w-5xl mx-auto p-6">
    <h1 class="text-3xl font-bold text-center mb-8 flex items-center justify-center gap-3">
      <i data-lucide="clock" class="w-8 h-8 text-blue-600"></i>
      Pending Toilets
    </h1>

    @forelse ($toilets as $toilet)
    <div class="bg-white p-5 rounded-xl shadow mb-6 border border-gray-200">
      <h2 class="text-xl font-semibold text-blue-700 mb-1">{{ $toilet->name }}</h2>
      <p class="text-sm text-gray-600">{{ $toilet->address }}</p>
      <p class="text-sm mb-3">{{ $toilet->description }}</p>

      {{-- Images --}}
      <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 mb-3">
      @if (!empty($toilet->images) && is_array($toilet->images))
      @foreach ($toilet->images as $image)
      <img src="{{ asset('storage/' . $image) }}" alt="Toilet Image"
      class="cursor-pointer w-full h-32 object-cover rounded-lg border border-gray-300 shadow-sm hover:scale-105 transition-transform duration-200"
      onclick="showImageOverlay('{{ asset('storage/' . $image) }}')" />
      @endforeach
    @else
      <p class="text-sm text-gray-400 italic col-span-full">No images available</p>
    @endif
      </div>

      <!-- Image Overlay -->
      <div id="imageOverlay"
      class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 invisible pointer-events-none">
      <img id="overlayImage" src="" class="max-w-full max-h-[90vh] rounded-lg shadow-lg border-4 border-white" />
      </div>

      {{-- Actions --}}
      <div class="flex gap-3">
      <form action="{{ route('admin.toilets.approve', $toilet->id) }}" method="POST">
        @csrf
        <button class="flex items-center gap-1 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
        <i data-lucide="check-circle" class="w-4 h-4"></i> Approve
        </button>
      </form>

      <form action="{{ route('admin.toilets.delete', $toilet->id) }}" method="POST"
        onsubmit="return confirm('Are you sure you want to deny this toilet?')">
        @csrf
        @method('DELETE')
        <button class="flex items-center gap-1 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
        <i data-lucide="x-circle" class="w-4 h-4"></i> Deny
        </button>
      </form>
      </div>
    </div>
  @empty
    <p class="text-center text-gray-500 italic mt-8">No pending toilets found.</p>
  @endforelse
  </div>

  <div class="fixed bottom-0 left-0 right-0 bg-white border-t py-3 px-6 shadow-inner text-center">
    <a href="{{ route('admindashboard') }}"
      class="text-blue-600 font-semibold hover:underline flex justify-center items-center gap-1">
      <i data-lucide="arrow-left" class="w-4 h-4"></i> Back
    </a>
  </div>

  <script>
    function showImageOverlay(src) {
      const overlay = document.getElementById('imageOverlay');
      const img = document.getElementById('overlayImage');
      img.src = src;
      overlay.classList.remove('invisible', 'pointer-events-none');
    }

    document.addEventListener('click', function (e) {
      const overlay = document.getElementById('imageOverlay');
      if (e.target === overlay) {
        overlay.classList.add('invisible', 'pointer-events-none');
      }
    });
  </script>
</body>

</html>