<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>All Toilet Reviews</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Lucide Icons -->
  <script type="module">
    import { createIcons, icons } from "https://unpkg.com/lucide@latest/dist/esm/lucide.js";
    window.addEventListener("DOMContentLoaded", () => createIcons({ icons }));
  </script>
</head>

<body class="bg-gray-50 text-gray-800 p-6">
  <div class="max-w-5xl mx-auto">
    <h1 class="text-3xl font-bold text-center mb-8 flex items-center justify-center gap-3">
      <i data-lucide="star" class="w-8 h-8 text-yellow-500"></i>
      Toilet Reviews
    </h1>

    <form method="GET" action="{{ route('allreviews') }}" class="mb-6">
      <div class="relative">
        <input type="text" name="search" placeholder="Search by toilet name" value="{{ request('search') }}"
          class="w-full p-3 pl-10 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" />
        <i data-lucide="search" class="absolute left-3 top-3.5 w-5 h-5 text-gray-400"></i>
      </div>
    </form>

    @forelse($reviews as $toiletName => $groupedReviews)
    <div class="mb-8">
      <h2 class="text-lg font-semibold text-blue-700 flex items-center gap-2">
      <i data-lucide="toilet" class="w-5 h-5 text-blue-600"></i> {{ $toiletName }}
      </h2>
      <ul class="space-y-4 mt-2">
      @foreach($groupedReviews as $review)
      <li class="p-4 border rounded-md bg-white shadow-sm">
        <div class="text-yellow-500 mb-1 text-lg">
        @for ($i = 0; $i < floor($review->rating); $i++) ★ @endfor
        @for ($i = floor($review->rating); $i < 5; $i++) ☆ @endfor
        </div>
        <p class="text-sm mb-1 italic">{{ $review->comment ?? 'No comment' }}</p>
        <p class="text-xs text-gray-500 flex items-center gap-1">
        <i data-lucide="user" class="w-4 h-4 text-gray-400"></i>
        {{ $review->user->email ?? 'Anonymous' }} — {{ $review->created_at->format('M d, Y') }}
        </p>

        @if (!empty($review->images) && is_array($review->images))
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 mt-2">
        @foreach ($review->images as $image)
      <img src="{{ asset('storage/' . $image) }}" alt="Review Image"
        class="cursor-pointer w-full h-24 object-cover rounded shadow hover:scale-105 transition"
        onclick="showImageOverlay('{{ asset('storage/' . $image) }}')" />
      @endforeach
        </div>

        <!-- Image Overlay -->
        <div id="imageOverlay"
        class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 invisible pointer-events-none">
        <img id="overlayImage" src="" class="max-w-full max-h-[90vh] rounded-lg shadow-lg border-4 border-white" />
        </div>
      @endif

      </li>
    @endforeach
      </ul>
    </div>
  @empty
    <p class="text-gray-500 flex items-center gap-2">
      <i data-lucide="x-circle" class="w-5 h-5 text-gray-400"></i> No reviews found.
    </p>
  @endforelse
  </div>

  <div class="fixed bottom-0 left-0 right-0 bg-white border-t py-3 px-6 shadow-inner text-center">
    <a href="{{ route('admindashboard') }}"
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