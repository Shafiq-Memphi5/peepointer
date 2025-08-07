<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Coming Soon</title>
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
</head>

<body class="flex flex-col items-center justify-center min-h-full relative">
    <div class="text-center p-6 bg-white rounded-lg shadow-lg max-w-md w-full mx-4">
        <div id="icon" class="mb-4"></div>
        <h1 class="text-4xl font-bold text-gray-700 mb-2">Coming Soon</h1>
        <p class="text-gray-500">We’re working hard to bring you this feature.</p>
    </div>

    <div class="fixed bottom-0 left-0 right-0 bg-white border-t py-3 px-6 shadow-inner text-center">
        <a href="{{ route('admindashboard') }}"
            class="text-blue-600 font-semibold hover:underline flex justify-center items-center gap-1">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Back
        </a>
    </div>
</body>

</html>