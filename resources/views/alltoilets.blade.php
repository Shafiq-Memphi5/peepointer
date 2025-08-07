<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Accepted Toilets</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- ✅ Lucide Icons -->
    <script type="module">
        import { createIcons, icons } from "https://unpkg.com/lucide@latest/dist/esm/lucide.js";
        window.addEventListener("DOMContentLoaded", () => createIcons({ icons }));
    </script>
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen p-6">

    <h1 class="text-3xl font-bold text-center mb-8 flex items-center justify-center gap-3">
      <i data-lucide="toilet" class="w-8 h-8 text-blue-600"></i>
      All Toilets
    </h1>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100 text-gray-600 uppercase text-sm">
                <tr>
                    <th class="px-6 py-3 text-left">Name</th>
                    <th class="px-6 py-3 text-left">Address</th>
                    <th class="px-6 py-3 text-center">Reviews</th>
                    <th class="px-6 py-3 text-center">Rating</th>
                    <th class="px-6 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse ($toilets as $toilet)
                    <tr>
                        <td class="px-6 py-4 font-medium">{{ $toilet->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $toilet->address }}</td>
                        <td class="px-6 py-4 text-center">{{ $toilet->review_count }}</td>
                        <td class="px-6 py-4 text-center">
                            @if ($toilet->review_count > 0)
                                {{ number_format($toilet->avg_rating, 1) }} / 5
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center space-x-3">
                            <a href="{{ route('admin.toilets.show', $toilet->id) }}"
                               class="inline-flex items-center px-3 py-1.5 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
                                <i data-lucide="eye" class="w-4 h-4 mr-1"></i> View
                            </a>
                            <form action="{{ route('admin.toilets.delete', $toilet->id) }}" method="POST" class="inline-block"
                                  onsubmit="return confirm('Are you sure you want to delete this toilet?');">
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
                        <td colspan="5" class="px-6 py-6 text-center text-gray-500">No accepted toilets found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="fixed bottom-0 left-0 right-0 bg-white border-t py-3 px-6 shadow-inner text-center">
    <a href="{{ route('admindashboard') }}"
      class="text-blue-600 font-semibold hover:underline flex justify-center items-center gap-1">
      <i data-lucide="arrow-left" class="w-4 h-4"></i> Back
    </a>
  </div>
</body>
</html>
