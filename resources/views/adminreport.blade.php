<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Report Details</title>
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

  <div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow border border-gray-200">
    <h1 class="text-2xl font-bold mb-4 flex items-center gap-2 text-blue-700">
      <i data-lucide="flag" class="w-6 h-6"></i>
      Report Details
    </h1>

    <div class="mb-4">
      <h2 class="text-lg font-semibold mb-1">Toilet:</h2>
      <p class="text-gray-700">{{ $report->toilet->name ?? 'Unknown Toilet' }}</p>
    </div>

    <div class="mb-4">
      <h2 class="text-lg font-semibold mb-1">Submitted by:</h2>
      <p class="text-gray-700">{{ $report->user->email ?? 'Anonymous' }}</p>
    </div>

    <div class="mb-4">
      <h2 class="text-lg font-semibold mb-1">Message:</h2>
      <p class="text-gray-800 whitespace-pre-line">&nbsp;&nbsp;{{ $report->body }}</p>
    </div>

    @foreach ($report->images as $image)
    <div class="mb-6">
      <h2 class="text-lg font-semibold mb-2">Attached Images:</h2>
      <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
      <img src="{{ asset('storage/' . $image) }}" alt="Report Image"
        class="cursor-pointer w-full h-32 object-cover rounded border border-gray-300 shadow-sm hover:scale-105 transition"
        onclick="showImageOverlay('{{ asset('storage/' . $image) }}')" />
      </div>
    </div>
  @endforeach

    <!-- Image Overlay -->
    <div id="imageOverlay"
      class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 invisible pointer-events-none">
      <img id="overlayImage" src="" class="max-w-full max-h-[90vh] rounded-lg shadow-lg border-4 border-white" />
    </div>



    <p class="text-xs text-gray-500">
      Submitted on {{ $report->created_at->format('M d, Y H:i') }}
    </p>
  </div>

  <div class="fixed bottom-0 left-0 right-0 bg-white border-t py-3 px-6 shadow-inner text-center">
    <a href="{{ route('allreports') }}"
      class="text-blue-600 font-semibold hover:underline flex justify-center items-center gap-1">
      <i data-lucide="arrow-left" class="w-4 h-4"></i> Back
    </a>
  </div>


  <script>
    function showImageOverlay(imageUrl) {
      const overlay = document.getElementById('imageOverlay');
      const overlayImage = document.getElementById('overlayImage');
      overlayImage.src = imageUrl;
      overlay.classList.remove('invisible', 'pointer-events-none');

      overlay.onclick = () => {
        overlay.classList.add('invisible', 'pointer-events-none');
        overlayImage.src = '';
      };
    }
  </script>

</body>

</html>