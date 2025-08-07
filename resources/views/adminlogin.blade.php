<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Lucide Icons -->
    <script type="module">
        import { createIcons, icons } from 'https://unpkg.com/lucide@latest/dist/esm/lucide.js';
        window.addEventListener('DOMContentLoaded', () => {
            createIcons({ icons });
        });
    </script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">

    <form method="POST" action="{{ route('admin.login') }}" class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md space-y-6">
        @csrf

        <h2 class="text-2xl font-bold text-center text-gray-800">Admin Login</h2>

        @error('company_email')
            <div class="text-red-500 text-sm text-center">{{ $message }}</div>
        @enderror

        <div>
            <label for="company_email" class="block text-sm font-medium text-gray-700 mb-1">Company Email</label>
            <div class="relative">
                <input type="email" name="company_email" id="company_email"
                    class="w-full px-10 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none"
                    placeholder="admin@pee-pointer.com" required>
                <div class="absolute left-3 top-2.5 text-gray-400">
                    <i data-lucide="mail"></i>
                </div>
            </div>
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <div class="relative">
                <input type="password" name="password" id="password"
                    class="w-full px-10 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none"
                    placeholder="••••••••" required>
                <div class="absolute left-3 top-2.5 text-gray-400">
                    <i data-lucide="lock"></i>
                </div>
            </div>
        </div>

        <button type="submit"
            class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-all duration-150">
            Login
        </button>
    </form>

</body>
</html>
