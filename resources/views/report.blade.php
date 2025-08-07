<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Report Toilet</title>

  <!-- Google Fonts: Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white flex flex-col min-h-screen text-gray-800 font-sans" style="font-family: 'Inter', sans-serif;">

  <div class="max-w-2xl mx-auto w-full p-6 sm:p-8 flex flex-col flex-grow">

    <h1 class="text-2xl font-semibold text-center mb-6 flex items-center justify-center space-x-2">
      <i data-lucide="alert-triangle" class="w-6 h-6 text-red-600"></i>
      <span>Report Toilet</span>
    </h1>

    <form action="/toilet/{{ $toilet->id }}/addreport" method="POST" enctype="multipart/form-data" class="space-y-6">
      @csrf

      <input type="hidden" name="toilet_id" value="{{ $toilet->id }}">

      <!-- Body -->
      <div>
        <label for="body" class="block text-sm font-medium text-gray-700 mb-1">Describe the issue</label>
        <textarea name="body" id="body" rows="5" required placeholder="Explain what is wrong with this toilet..."
          class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500 resize-none transition"></textarea>
      </div>

      <!-- Image Upload -->
      <div>
        <label for="images" class="block text-sm font-medium text-gray-700 mb-1">Upload Images (optional)</label>
        <input type="file" name="images[]" id="images" multiple accept="image/*" class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4
                 file:rounded-md file:border-0 file:text-sm file:font-semibold
                 file:bg-red-50 file:text-red-700 hover:file:bg-red-100 cursor-pointer">
      </div>

      <!-- Submit Button -->
      <button type="submit"
        class="w-full bg-red-600 text-white font-semibold py-3 rounded-md hover:bg-red-700 transition flex items-center justify-center space-x-2">
        <i data-lucide="send" class="w-5 h-5"></i>
        <span>Submit Report</span>
      </button>
    </form>
  </div>

  <!-- Back button -->
  <div class="fixed bottom-0 left-0 right-0 bg-white border-t py-3 px-6 shadow-inner text-center">
    <a href="{{ route('home') }}"
      class="text-red-600 font-semibold hover:underline flex justify-center items-center gap-1">
      <i data-lucide="arrow-left" class="w-4 h-4"></i> Back
    </a>
  </div>

  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest/dist/lucide.min.js"></script>
  <script>
    window.addEventListener('DOMContentLoaded', () => {
      lucide.replace();
    });
  </script>

</body>

</html>