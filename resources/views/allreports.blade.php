<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin - Reports</title>
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

<body class="bg-gray-100 min-h-screen text-gray-800">

  <div class="max-w-6xl mx-auto p-6 space-y-6">
    <h1 class="text-3xl font-bold text-center mb-8 flex items-center justify-center gap-3">
      <i data-lucide="alert-triangle" class="w-8 h-8 text-red-600"></i>
      Reports Dashboard
    </h1>

    <form method="GET" action="{{ route('allreports') }}" class="max-w-md mx-auto mb-6">
      <input type="text" name="search" placeholder="Search by toilet name (e.g. S)" value="{{ request('search') }}"
        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
    </form>

    @if($reports->count())
    <div class="overflow-x-auto bg-white rounded shadow">
      <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Toilet Name</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reported By</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        @foreach ($reports as $report)
      <tr>
      <td class="px-6 py-4 whitespace-nowrap">{{ $report->toilet->name ?? 'Unknown' }}</td>
      <td class="px-6 py-4 whitespace-nowrap">{{ $report->user->email ?? 'Anonymous' }}</td>
      <td class="px-6 py-4 whitespace-nowrap max-w-xs truncate" title="{{ $report->reason }}">
        {{ $report->reason }}</td>
      <td class="px-6 py-4 whitespace-nowrap">{{ $report->created_at->format('M d, Y') }}</td>
      <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
        <a href="{{ route('adminreport', $report->id) }}" title="View Report"
        class="inline-flex items-center text-blue-600 hover:text-blue-800">
        <i data-lucide="eye" class="w-5 h-5"></i>
        </a>
        <form method="POST" action="{{ route('admin.reports.delete', $report->id) }}"
        onsubmit="return confirm('Are you sure you want to delete this report?')" class="inline-block">
        @csrf
        @method('DELETE')
        <button type="submit" title="Delete Report"
        class="text-red-600 hover:text-red-800 inline-flex items-center">
        <i data-lucide="trash-2" class="w-5 h-5"></i>
        </button>
        </form>
      </td>
      </tr>
      @endforeach
      </tbody>
      </table>
    </div>

    <div class="mt-6">
      {{ $reports->withQueryString()->links() }}
    </div>
  @else
    <p class="text-center text-gray-500 italic mt-8">No reports found.</p>
  @endif

  </div>

  <div class="fixed bottom-0 left-0 right-0 bg-white border-t py-3 px-6 shadow-inner text-center">
    <a href="{{ route('admindashboard') }}"
      class="text-blue-600 font-semibold hover:underline flex justify-center items-center gap-1">
      <i data-lucide="arrow-left" class="w-4 h-4"></i> Back
    </a>
  </div>

</body>

</html>