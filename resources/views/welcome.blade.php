<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Welcome | PeePointer</title>

  <!-- Google Fonts: Inter -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />

  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Use Inter font in Tailwind -->
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'ui-sans-serif', 'system-ui'],
          },
        },
      },
    };
  </script>

  <!-- Lucide Icons CDN -->
  <script type="module">
    import { createIcons, icons } from "https://unpkg.com/lucide@latest/dist/esm/lucide.js";
    window.addEventListener("DOMContentLoaded", () => createIcons({ icons }));
  </script>
</head>

<body class="bg-white min-h-screen flex items-center justify-center px-4 py-10 font-sans">

  <div class="text-center max-w-md">
    <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-800 mb-4">
      Welcome to PeePointer 🚻
    </h1>

    <p class="text-gray-600 text-base sm:text-lg mb-6">
      Discover nearby clean and accessible washrooms effortlessly. Whether you're in a new city or just exploring, we've
      got you covered.
    </p>

    <a href="{{ url('login') }}"
      class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg text-lg font-semibold hover:bg-blue-700 transition">
      <i data-lucide="log-in" class="w-5 h-5"></i>
      Get Started
    </a>
  </div>

</body>

</html>