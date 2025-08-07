<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Add Washroom | PeePointer</title>
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

    html,
    body {
      height: 100%;
      overflow-y: auto;
      max-width: 100%;
      overflow-x: hidden;
    }
  </style>
</head>

<body class="bg-white min-h-screen flex flex-col font-sans" onload="getLocation()">

  @auth
    <div class="flex-1 px-4 sm:px-8 max-w-3xl mx-auto w-full pb-24 pt-6">
      <form action="{{ route('washadd') }}" method="POST" enctype="multipart/form-data"
        class="bg-gray-100 p-4 sm:p-6 rounded-2xl shadow-xl space-y-6">
        @csrf

        <h2 class="text-xl font-semibold text-gray-800 mb-2">Add a Washroom</h2>

        <div>
          <label for="name" class="block text-gray-700 font-medium mb-1">Name:</label>
          <input type="text" id="name" name="name" required
            class="w-full border border-gray-300 rounded-xl p-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <div>
          <label for="address" class="block text-gray-700 font-medium mb-1">Address:</label>
          <input type="text" id="address" name="address" required
            class="w-full border border-gray-300 rounded-xl p-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <div>
          <label for="description" class="block text-gray-700 font-medium mb-1">Description:</label>
          <input type="text" id="description" name="description" placeholder="Description" required
            class="w-full border border-gray-300 rounded-xl p-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <div>
          <label for="pricing" class="block text-gray-700 font-medium mb-1">Pricing:</label>
          <select name="pricing" id="pricing" required
            class="w-full border border-gray-300 rounded-xl p-3 bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="Free">Free</option>
            <option value="Paid">Paid</option>
          </select>
        </div>

        <div>
          <label for="images" class="block text-gray-700 font-medium mb-1">Upload Images:</label>
          <input type="file" name="images[]" id="images" multiple required
            class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4
              file:rounded-full file:border-0 file:text-sm file:font-semibold
              file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
          <p class="text-red-600 font-semibold mt-1">At least one Image</p>
        </div>

        <input type="hidden" id="latitude" name="latitude" required />
        <input type="hidden" id="longitude" name="longitude" required />

        <button type="submit"
          class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition duration-200">
          Add Washroom
        </button>
      </form>
    </div>

    <nav class="fixed bottom-0 left-0 right-0 bg-white border-t shadow-md flex justify-around py-2 z-10">
      <a href="{{ route('home') }}" class="flex flex-col items-center text-gray-700 text-sm" aria-label="Map">
        <i data-lucide="map" class="w-6 h-6 mb-1"></i>
        <span>Map</span>
      </a>
      <a href="{{ route('washadd') }}" class="flex flex-col items-center text-gray-700 text-sm" aria-label="Add">
        <i data-lucide="plus-circle" class="w-6 h-6 mb-1"></i>
        <span>Add</span>
      </a>
      <a href="{{ route('settings') }}" class="flex flex-col items-center text-gray-700 text-sm" aria-label="Settings">
        <i data-lucide="settings" class="w-6 h-6 mb-1"></i>
        <span>Settings</span>
      </a>
    </nav>
  @else
    <p class="text-center mt-8 text-gray-600">
      Please <a href="{{ route('login') }}" class="text-blue-600 underline">Log in</a> to add a washroom.
    </p>
  @endauth

  <script>
    function getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
      } else {
        alert("Geolocation is not supported by this browser.");
      }
    }
    function showPosition(position) {
      document.getElementById("latitude").value = position.coords.latitude;
      document.getElementById("longitude").value = position.coords.longitude;
    }
    function showError(error) {
      switch (error.code) {
        case error.PERMISSION_DENIED:
          alert("Please allow the request for Geolocation.");
          location.reload();
          break;
        case error.POSITION_UNAVAILABLE:
          alert("Location information is unavailable.");
          break;
        case error.TIMEOUT:
          alert("The request to get user location timed out.");
          break;
        case error.UNKNOWN_ERROR:
          alert("An unknown error occurred.");
          break;
      }
    }
  </script>

</body>

</html>
