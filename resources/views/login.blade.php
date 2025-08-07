<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />

  <script src="https://cdn.tailwindcss.com"></script>

  <title>PeePointer</title>

  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>

<body class="bg-gray-50 min-h-screen flex flex-col items-center justify-center p-6">
  <div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">
    <h1 class="text-3xl font-bold mb-4 text-center text-gray-800">Welcome to PeePointer</h1>
    <p class="mb-6 text-center text-gray-600">Enter your email to receive an OTP for verification.</p>

    <form method="post" action="/send-otp" class="space-y-6">
      @csrf
      <input type="email" name="email" placeholder="Enter your email" required
        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

      <input type="submit" value="Get OTP" name="get_otp"
        class="w-full bg-blue-600 text-white font-semibold py-2 rounded-md hover:bg-blue-700 cursor-pointer transition">
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