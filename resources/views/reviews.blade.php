<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Reviews for {{ $toilet->name }}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white flex flex-col min-h-screen text-gray-800 font-sans" style="font-family: 'Inter', sans-serif;">

  <div class="max-w-4xl mx-auto w-full p-4 sm:p-8 flex flex-col flex-grow">

    <h1 class="text-xl sm:text-2xl font-semibold mb-6 text-center flex items-center justify-center space-x-2">
      <i data-lucide="toilet-paper" class="w-6 h-6"></i>
      <span>{{ $toilet->name }}</span> <br>
    </h1>

    {{-- Toilet Images --}}
    @if (!empty($toilet->images) && is_array($toilet->images) && count($toilet->images) > 0)
    <section class="mb-8">
      <h2 class="text-lg font-semibold mb-4 flex items-center space-x-2">
      <i data-lucide="image" class="w-5 h-5"></i>
      <span>Toilet Images</span>
      </h2>
      <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
      @foreach ($toilet->images as $image)
      <img src="{{ asset('storage/' . $image) }}" alt="Image of {{ $toilet->name }}"
      class="w-full h-32 sm:h-40 object-cover rounded-md border border-gray-200 shadow-sm cursor-pointer transition-transform duration-300"
      onclick="showImageOverlay('{{ asset('storage/' . $image) }}')" />
    @endforeach
      </div>
    </section>
  @endif

    <!-- Image Overlay -->
    <div id="imageOverlay"
      class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 invisible pointer-events-none">
      <img id="overlayImage" src="" class="max-w-full max-h-[90vh] rounded-lg shadow-lg border-4 border-white" />
    </div>

    {{-- Reviews --}}
    <section>
      <h2 class="text-lg font-semibold mb-4 flex items-center space-x-2">
        <i data-lucide="message-circle" class="w-5 h-5"></i>
        <span>User Reviews</span>
      </h2>

      @if($reviews->count())
      <ul class="space-y-6 max-h-[60vh] overflow-y-auto">
      @foreach($reviews as $review)
      <li class="border border-gray-300 rounded-lg p-4 shadow-sm">
        {{-- Rating --}}
        <div class="flex space-x-1 text-yellow-400 mb-2">
        @for ($i = 0; $i < floor($review->rating); $i++)
      <i data-lucide="star" class="w-5 h-5"></i>
      @endfor
        @for ($i = floor($review->rating); $i < 5; $i++)
      <i data-lucide="star" class="w-5 h-5 text-gray-300"></i>
      @endfor
        </div>

        {{-- Comment --}}
        <p class="text-gray-700 mb-2 text-sm sm:text-base leading-relaxed italic">
        {{ $review->comment ?? 'No comment' }}
        </p>

        {{-- Review Images --}}
        @if (!empty($review->images) && is_array($review->images) && count($review->images) > 0)
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 mb-2">
        @foreach($review->images as $image)
      <img src="{{ asset('storage/' . $image) }}" alt="Review image by {{ $review->user->email ?? 'user' }}"
        class="cursor-pointer w-full h-32 sm:h-40 object-cover rounded-md border border-gray-200 shadow-sm hover:scale-105 transition"
        onclick="showImageOverlay('{{ asset('storage/' . $image) }}')" />
      @endforeach
        </div>
      @else
      <p class="text-gray-400 text-xs mb-2">No images provided for this review.</p>
      @endif

        <!-- Image Overlay -->
        <div id="imageOverlay"
        class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 invisible pointer-events-none">
        <img id="overlayImage" src="" class="max-w-full max-h-[90vh] rounded-lg shadow-lg border-4 border-white" />
        </div>

        {{-- Reviewer & Review Date --}}
        <small class="text-gray-500 text-xs sm:text-sm block">
        Reviewed by <strong>{{ $review->user->email ?? 'Anonymous' }}</strong> on
        {{ $review->created_at->format('M d, Y') }}
        </small>
      </li>
    @endforeach
      </ul>
    @else
      <p class="text-center text-gray-500 text-sm sm:text-base mt-8">
      No reviews found for this toilet.
      </p>
    @endif
    </section>

  </div>

  {{-- Bottom Back Button --}}
  <div class="fixed bottom-0 left-0 right-0 bg-white border-t py-3 px-6 shadow-inner text-center">
    <a href="{{ route('home') }}"
      class="text-blue-600 font-semibold hover:underline flex items-center justify-center space-x-2">
      <i data-lucide="arrow-left" class="w-5 h-5"></i>
      <span>Back</span>
    </a>
  </div>

  <script src="https://unpkg.com/lucide@latest/dist/lucide.min.js"></script>
  <script>
    window.addEventListener('DOMContentLoaded', () => {
      lucide.replace();
    });
  </script>


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