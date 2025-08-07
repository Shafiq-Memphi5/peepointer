<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
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
    </style>
</head>

<body class="bg-white flex flex-col min-h-screen relative">
    @if(Auth::check())
        <div class="max-w-4xl mx-auto w-full flex flex-col min-h-screen p-4 sm:p-8">

            <h1 class="text-center text-2xl font-semibold text-gray-800 mb-6">
                Howdy, {{ explode('@', Auth::user()->email)[0] }}!
            </h1>

            <div class="bg-gray-100 p-4 rounded-xl shadow text-center  gap-4 mb-6">
                <h1 class="h-16 bg-gray-100 rounded">
                    <span class="text-xl font-bold text-blue-600 text-center">PEE POINTER, YOUR WAY OUT</span>
                </h1>
            </div>

            <!-- Map: fixed height -->
            <div id="map"
                class="w-full bg-gray-200 rounded-xl shadow-inner h-[300px] flex items-center justify-center sticky top-0 z-20">
                <p class="text-gray-500">Loading map...</p>
            </div>

            <!-- Toilet Cards: scrollable area -->
            <div id="toilet-list" class="flex-1 overflow-y-auto space-y-4 pt-4 pb-24"
                style="max-height: calc(100vh - 400px);">
                <!-- Toilet cards injected here -->
            </div>

        </div>

        <!-- Bottom Navigation -->
        <nav class="fixed bottom-0 left-0 right-0 bg-white border-t shadow-md flex justify-around py-2 z-10">
            <a href="{{ route('home') }}" class="flex flex-col items-center text-gray-700 text-sm" aria-label="Map">
                <i data-lucide="map" class="w-6 h-6 mb-1"></i>
                <span>Map</span>
            </a>
            <a href="{{ route('washadd') }}" class="flex flex-col items-center text-gray-700 text-sm" aria-label="Add">
                <i data-lucide="plus-circle" class="w-6 h-6 mb-1"></i>
                <span>Add</span>
            </a>
            <a href="{{ route('settings') }}" class="flex flex-col items-center text-gray-700 text-sm"
                aria-label="Settings">
                <i data-lucide="settings" class="w-6 h-6 mb-1"></i>
                <span>Settings</span>
            </a>
        </nav>
    @endif

    <!-- Scripts -->
    <script>
        let map;

        function initMapWithLocation(position) {
            const userLocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude,
            };

            map = new google.maps.Map(document.getElementById("map"), {
                center: userLocation,
                zoom: 15,
                styles: [
                    { featureType: "poi", stylers: [{ visibility: "off" }] },
                    { featureType: "poi.park", stylers: [{ visibility: "off" }] },
                    { featureType: "poi.business", stylers: [{ visibility: "off" }] },
                    { featureType: "transit", stylers: [{ visibility: "off" }] },
                    { featureType: "administrative", stylers: [{ visibility: "off" }] },
                    { featureType: "road", stylers: [{ visibility: "on" }] },
                    { featureType: "road.local", elementType: "labels", stylers: [{ visibility: "on" }] },
                    { featureType: "road.arterial", elementType: "labels", stylers: [{ visibility: "on" }] },
                    { featureType: "road.highway", elementType: "labels", stylers: [{ visibility: "on" }] },
                    { featureType: "water", stylers: [{ visibility: "on" }] },
                    { featureType: "landscape", stylers: [{ visibility: "on" }] },
                    { elementType: "labels.icon", stylers: [{ visibility: "off" }] }
                ]
            });

            new google.maps.Marker({
                position: userLocation,
                map,
                title: "You are here",
                icon: "https://maps.google.com/mapfiles/ms/icons/red-dot.png"
            });

            fetch(`/toilets/nearby?lat=${userLocation.lat}&lng=${userLocation.lng}`)
                .then(response => response.json())
                .then(data => {
                    const mapToilets = data.allToilets;
                    const closestToilets = data.closestToilets;

                    const listContainer = document.getElementById("toilet-list");
                    listContainer.innerHTML = '';

                    // Plot ALL toilets on the map
                    mapToilets.forEach(toilet => {
                        new google.maps.Marker({
                            position: {
                                lat: parseFloat(toilet.latitude),
                                lng: parseFloat(toilet.longitude)
                            },
                            map: map,
                            title: toilet.name,
                            icon: "https://maps.google.com/mapfiles/ms/icons/blue-dot.png"
                        });
                    });

                    // Show ONLY 5 closest toilets in cards
                    if (closestToilets.length === 0) {
                        listContainer.innerHTML = `<p class="text-gray-500 text-center">No nearby toilets found.</p>`;
                        return;
                    }

                    closestToilets.forEach(toilet => {
                        const fullStars = Math.floor(toilet.avg_rating || 0);
                        const emptyStars = 5 - fullStars;
                        const stars = '★'.repeat(fullStars) + '☆'.repeat(emptyStars);

                        const card = document.createElement('div');
                        card.className = 'p-4 bg-white rounded-xl shadow space-y-1';
                        card.innerHTML = `
                            <h2 class="text-lg font-semibold text-gray-800">${toilet.name}</h2>
                            <p class="text-sm text-gray-600">${toilet.address}</p>
                            <p class="text-sm text-gray-500">${toilet.description || 'No description available.'}</p>
                            <div class="flex items-center space-x-1 text-yellow-400 text-sm mt-1 mb-1">
                                <span>${stars}</span>
                                <a href="/toilet/${toilet.id}/reviews" class="text-gray-500 underline">(${toilet.reviews_count || 0} reviews)</a>
                            </div>
                            <a href="/direction/${toilet.id}" class="text-blue-500 text-sm underline">
                                Get Directions
                            </a>
                        `;
                        listContainer.appendChild(card);
                    });
                });

        }

        function handleLocationError(error) {
            document.getElementById("map").innerHTML = `<p class="text-red-500 p-4">Location access denied. Please enable location to view nearby toilets.</p>`;
            console.error("Geolocation error:", error);
        }

        function initGeolocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(initMapWithLocation, handleLocationError);
            } else {
                handleLocationError({ message: "Geolocation not supported" });
            }
        }

        window.onload = initGeolocation;
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_FRONTEND_KEY') }}I&callback=initMap"></script>
</body>

</html>