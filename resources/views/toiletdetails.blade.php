<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Toilet Details - {{ $toilet->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Lucide Icons -->
    <script type="module">
        import { createIcons, icons } from "https://unpkg.com/lucide@latest/dist/esm/lucide.js";
        window.addEventListener("DOMContentLoaded", () => createIcons({ icons }));
    </script>
</head>

<body class="bg-gray-100 min-h-screen p-6 text-gray-800">

    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow p-8">

        <!-- Title -->
        <h1 class="text-3xl font-bold mb-4 text-purple-700">{{ $toilet->name }}</h1>

        <!-- Location -->
        <p class="mb-4">
            <i data-lucide="map-pin" class="inline w-5 h-5 text-blue-600 mr-1"></i>
            <strong>Location:</strong> {{ $toilet->address }}
        </p>

        <!-- Toilet Images -->
        @if (!empty($toilet->images) && is_array($toilet->images))
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-6">
                @foreach ($toilet->images as $image)
                    <img src="{{ asset('storage/' . $image) }}" alt="Toilet Image"
                        class="w-full h-32 object-cover rounded shadow cursor-pointer hover:scale-105 transition"
                        onclick="showImageOverlay('{{ asset('storage/' . $image) }}')" />
                @endforeach
            </div>
        @else
            <p class="text-sm text-gray-400 italic mb-6">No toilet images uploaded.</p>
        @endif

        <!-- Average Rating -->
        @php
            $fullStars = floor($avgRating);
            $halfStar = ($avgRating - $fullStars) >= 0.5;
            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
        @endphp

        <div class="flex items-center space-x-1 mb-4">
            @for ($i = 0; $i < $fullStars; $i++)
                <i data-lucide="star" class="w-5 h-5 text-yellow-400"></i>
            @endfor
            @if ($halfStar)
                <i data-lucide="star-half" class="w-5 h-5 text-yellow-400"></i>
            @endif
            @for ($i = 0; $i < $emptyStars; $i++)
                <i data-lucide="star" class="w-5 h-5 text-gray-300"></i>
            @endfor
            <span class="ml-2 text-sm font-semibold text-gray-700">
                {{ number_format($avgRating, 1) }} / 5
            </span>
        </div>

        <!-- Reviews -->
        <h2 class="text-2xl font-semibold mb-4">Reviews ({{ $toilet->reviews->count() }})</h2>

        @if ($toilet->reviews->count() > 0)
            <ul class="space-y-4">
                @foreach ($toilet->reviews as $review)
                    <li class="border rounded p-4 shadow-sm bg-gray-50">
                        {{-- Star Rating per Review --}}
                        @php
                            $stars = $review->rating;
                            $full = floor($stars);
                            $half = ($stars - $full) >= 0.5;
                            $empty = 5 - $full - ($half ? 1 : 0);
                        @endphp

                        <div class="flex items-center mb-2">
                            @for ($i = 0; $i < $full; $i++)
                                <i data-lucide="star" class="w-5 h-5 text-yellow-400 mr-1"></i>
                            @endfor
                            @if ($half)
                                <i data-lucide="star-half" class="w-5 h-5 text-yellow-400 mr-1"></i>
                            @endif
                            @for ($i = 0; $i < $empty; $i++)
                                <i data-lucide="star" class="w-5 h-5 text-gray-300 mr-1"></i>
                            @endfor

                            <span class="ml-2 text-sm font-semibold text-gray-700">
                                {{ number_format($stars, 1) }} / 5
                            </span>
                        </div>

                        <!-- Comment -->
                        <p class="text-gray-700">{{ $review->comment ?? 'No comment provided.' }}</p>
                        <p class="text-xs text-gray-400 mt-1">
                            Reviewed on {{ $review->created_at->format('M d, Y') }}
                        </p>

                        <!-- Review Images -->
                        @if (!empty($review->images) && is_array($review->images))
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 mt-2">
                                @foreach ($review->images as $img)
                                    <img src="{{ asset('storage/' . $img) }}" alt="Review Image"
                                        class="cursor-pointer w-full h-24 object-cover rounded shadow hover:scale-105 transition"
                                        onclick="showImageOverlay('{{ asset('storage/' . $img) }}')" />
                                @endforeach
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500 italic">No reviews yet.</p>
        @endif

        <!-- Back Button -->
        <div class="mt-8">
            <a href="{{ route('admin.toilets.accepted') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i> Back
            </a>
        </div>
    </div>

    <!-- Image Overlay -->
    <div id="imageOverlay"
        class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 invisible pointer-events-none">
        <img id="overlayImage" src="" class="max-w-full max-h-[90vh] rounded-lg shadow-lg border-4 border-white" />
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
