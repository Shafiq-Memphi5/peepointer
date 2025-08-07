<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Verify OTP</title>

  <!-- Google Fonts: Inter -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />

  <script src="https://cdn.tailwindcss.com"></script>
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

  <!-- Lucide Icons -->
  <script type="module">
    import { createIcons, icons } from "https://unpkg.com/lucide@latest/dist/esm/lucide.js";
    window.addEventListener("DOMContentLoaded", () => createIcons({ icons }));
  </script>

</head>

<body class="bg-gray-50 min-h-screen flex flex-col items-center justify-center p-6 font-sans">

  <div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">
    <h1 class="text-2xl font-semibold mb-4 text-center">Verify Your OTP</h1>
    <p class="mb-6 text-center text-gray-600">Enter the OTP sent to your email.</p>

    <form method="post" action="/verify-otp" class="space-y-4">
      @csrf
      <input type="email" name="email" required readonly value="{{ session('email') }}"
        class="w-full border border-gray-300 rounded-md px-4 py-2 bg-gray-100 cursor-not-allowed" />

      <input type="text" name="otp" placeholder="Enter your OTP" required
        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />

      <button type="submit"
        class="w-full bg-blue-600 text-white font-semibold py-2 rounded-md hover:bg-blue-700 cursor-pointer transition flex items-center justify-center gap-2">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
        Verify OTP
      </button>
    </form>

    @if(session('message'))
    <p class="mt-4 text-green-600 text-center">{{ session('message') }}</p>
  @endif

    @if($errors->any())
    <ul class="mt-4 text-red-600 list-disc list-inside">
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
    </ul>
  @endif
  </div>

</body>

</html>