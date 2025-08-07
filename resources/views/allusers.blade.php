<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>User Management</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Lucide Icons -->
    <script type="module">
        import { createIcons, icons } from "https://unpkg.com/lucide@latest/dist/esm/lucide.js";
        window.addEventListener("DOMContentLoaded", () => createIcons({ icons }));
    </script>
</head>

<body class="bg-gray-100 min-h-screen p-6 text-gray-800">
    <div class="max-w-5xl mx-auto bg-white rounded-lg shadow p-6">
        <h1 class="text-3xl font-bold text-center mb-8 flex items-center justify-center gap-3">
            <i data-lucide="users" class="w-8 h-8 text-green-600"></i>
            User Management
        </h1>

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 text-gray-600 uppercase text-sm">
                    <tr>
                        <th class="px-6 py-3 text-left">Name</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Created At</th>
                        <th class="px-6 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($users as $user)
                        <tr>
                            <td class="px-6 py-4 font-medium">{{ explode('@', $user->email)[0] }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this user?');"
                                      class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-3 py-1.5 bg-red-500 text-white text-sm rounded hover:bg-red-600">
                                        <i data-lucide="trash" class="w-4 h-4 mr-1"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-6 text-center text-gray-500">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="fixed bottom-0 left-0 right-0 bg-white border-t py-3 px-6 shadow-inner text-center">
    <a href="{{ route('admindashboard') }}"
      class="text-blue-600 font-semibold hover:underline flex justify-center items-center gap-1">
      <i data-lucide="arrow-left" class="w-4 h-4"></i> Back
    </a>
  </div>
</body>

</html>
