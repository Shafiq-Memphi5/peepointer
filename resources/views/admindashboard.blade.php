<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- ✅ Lucide Icons CDN -->
    <script type="module">
        import { createIcons, icons } from "https://unpkg.com/lucide@latest/dist/esm/lucide.js";
        window.addEventListener("DOMContentLoaded", () => createIcons({ icons }));
    </script>
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen p-6">

    <h1 class="text-3xl font-bold mb-8 text-center">Admin Dashboard</h1>

    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">

        <!-- 🚽 Manage Toilets -->
        <a href="{{ route('pendingtoilets') }}"
            class="block bg-white p-6 rounded-lg shadow hover:bg-blue-50 transition">
            <div class="flex items-center space-x-3">
                <i data-lucide="clock" class="w-6 h-6 text-blue-600"></i>
                <h2 class="text-xl font-semibold">Pending Toilets</h2>
            </div>
            <p class="text-sm text-gray-600 mt-2 ml-8">View, approve, or delete toilets</p>
        </a>

        <!-- ⭐ View Reviews -->
        <a href="{{ route('allreviews') }}" class="block bg-white p-6 rounded-lg shadow hover:bg-blue-50 transition">
            <div class="flex items-center space-x-3">
                <i data-lucide="star" class="w-6 h-6 text-yellow-500"></i>
                <h2 class="text-xl font-semibold">View Reviews</h2>
            </div>
            <p class="text-sm text-gray-600 mt-2 ml-8">Read user reviews for toilets</p>
        </a>

        <!-- ⚠️ Reports -->
        <a href="{{ route('allreports') }}" class="block bg-white p-6 rounded-lg shadow hover:bg-blue-50 transition">
            <div class="flex items-center space-x-3">
                <i data-lucide="alert-triangle" class="w-6 h-6 text-red-600"></i>
                <h2 class="text-xl font-semibold">Reports</h2>
            </div>
            <p class="text-sm text-gray-600 mt-2 ml-8">Check all submitted reports</p>
        </a>

        <a href="{{ route('allusers') }}" class="block bg-white p-6 rounded-lg shadow hover:bg-blue-50 transition">
            <div class="flex items-center space-x-3">
                <i data-lucide="users" class="w-6 h-6 text-green-600"></i>
                <h2 class="text-xl font-semibold">User Management</h2>
            </div>
            <p class="text-sm text-gray-600 mt-2 ml-8">Check all submitted reports</p>
        </a>

        <a href="{{ route('analytics') }}" class="block bg-white p-6 rounded-lg shadow hover:bg-blue-50 transition">
            <div class="flex items-center space-x-3">
                <i data-lucide="chart-area" class="w-6 h-6 text-black-600"></i>
                <h2 class="text-xl font-semibold">Analytics</h2>
            </div>
            <p class="text-sm text-gray-600 mt-2 ml-8">Check all submitted reports</p>
        </a>

        <a href="{{ route('admin.toilets.accepted') }}" class="block bg-white p-6 rounded-lg shadow hover:bg-blue-50 transition">
            <div class="flex items-center space-x-3">
                <i data-lucide="toilet" class="w-6 h-6 text-blue-600"></i>
                <h2 class="text-xl font-semibold">Toilet Management</h2>
            </div>
            <p class="text-sm text-gray-600 mt-2 ml-8">Check all submitted reports</p>
        </a>

    </div>

    <form method="post" action="{{ route('admin.logout') }}" class="fixed bottom-0 left-0 right-0 bg-white border-t py-3 px-6 shadow-inner text-center">
    @csrf
    <button type="submit"
        class="text-red-600 font-semibold hover:underline flex justify-center items-center gap-2 mx-auto">
        <i data-lucide="log-out" class="w-4 h-4"></i>
        <span>LOGOUT</span>
    </button>
</form>


</body>

</html>