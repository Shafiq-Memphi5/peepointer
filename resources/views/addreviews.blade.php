<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Leave a Review</title>
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

<body class="bg-white min-h-screen flex flex-col justify-between text-gray-800">

  <div class="max-w-xl mx-auto w-full p-6 space-y-6">
    <h1 class="text-2xl font-bold text-center">Review for {{ $toilet->name }}</h1>

    <form method="POST" action="/toilet/{{ $toilet->id }}/addreview" enctype="multipart/form-data" class="space-y-4">
      @csrf

      <!-- Rating -->
      <div>
        <label for="rating" class="block text-sm font-medium mb-1">Rating <span class="text-red-500">*</span></label>
        <select name="rating" id="rating" required class="w-full border border-gray-300 rounded-md px-4 py-2">
          <option value="">Select stars</option>
          @for ($i = 5; $i >= 1; $i--)
        <option value="{{ $i }}">{{ str_repeat('★', $i) }}</option>
      @endfor
        </select>
      </div>

      <!-- Comment -->
      <div>
        <label for="comment" class="block text-sm font-medium mb-1">Comment (optional)</label>
        <textarea name="comment" id="comment" rows="4"
          class="w-full border border-gray-300 rounded-md px-4 py-2 resize-none"
          placeholder="What was your experience like?"></textarea>
      </div>

      <div>
        <label for="images" class="block text-sm font-medium mb-1">Add Photos (optional)</label>
        <input type="file" name="images[]" id="images" multiple class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4
                      file:rounded-full file:border-0 file:text-sm file:font-semibold
                      file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
      </div>

      <!-- Submit -->
      <div>
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">
          Submit Review
        </button>
      </div>
    </form>

    <div class="text-center space-y-2">
      <p class="text-gray-500 text-sm">
        Want to report this toilet?
      </p>
      <a href="/toilet/{{ $toilet->id }}/report"
        class="inline-flex items-center text-red-600 font-semibold hover:underline">
        <span class="mr-2 text-lg">⚠️</span>
        REPORT
      </a>
    </div>


    @if ($errors->any())
    <div class="bg-red-100 text-red-700 p-3 rounded-md mt-4">
      <ul class="list-disc pl-4 text-sm">
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
      </ul>
    </div>
  @endif
  </div>

  <!-- Bottom Back Button -->
  <div class="fixed bottom-0 left-0 right-0 bg-white border-t py-3 px-6 shadow-inner text-center">
    <a href="{{ route('home') }}"
      class="text-blue-600 font-semibold hover:underline flex justify-center items-center gap-1">
      <i data-lucide="arrow-left" class="w-4 h-4"></i> Back
    </a>
  </div>

</body>

</html>