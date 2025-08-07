<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />

  <script src="https://cdn.tailwindcss.com"></script>
  <title>Directions to {{ $toilet->name }}</title>

  <style>
    body {
      font-family: 'Inter', sans-serif;
    }

    #map {
      height: 75vh;
      width: 100%;
    }
  </style>
</head>

<body class="bg-white flex flex-col min-h-screen relative text-gray-800">
  <div class="max-w-4xl mx-auto w-full p-4 sm:p-8 flex flex-col min-h-screen">

    <!-- Map -->
    <div id="map" class="w-full bg-gray-200 rounded-xl shadow-inner mb-6 flex items-center justify-center">
      <p class="text-gray-500">Loading map...</p>
    </div>

    <div class="text-center">
      <p class="text-gray-600 text-sm mb-4">
        Use the map above to navigate to: <strong>{{ $toilet->name }}</strong>
      </p>
    </div>
  </div>

  <!-- Bottom Navigation with Back and I've Reached -->
  <nav
    class="fixed bottom-0 left-0 right-0 bg-white border-t shadow-md flex justify-between items-center py-2 px-4 z-10 space-x-4">
    <button class="flex-1 flex flex-col items-center text-gray-700 text-sm">
      <a href="{{ route('home') }}" class="w-full text-center">
        ←<br />
        Back
      </a>
    </button>

    <button id="iveReachedBtn" disabled
      class="flex-1 bg-blue-600 text-white font-semibold py-2 rounded-md opacity-50 cursor-not-allowed"
      onclick="window.location.href='/toilet/{{ $toilet->id }}/review'">
      I've Reached
    </button>
  </nav>

  <!-- Map Script -->
  <script>
    // Distance calculator (meters)
    function getDistanceFromLatLonInMeters(lat1, lon1, lat2, lon2) {
      const R = 6371000; // Earth radius in meters
      const dLat = ((lat2 - lat1) * Math.PI) / 180;
      const dLon = ((lon2 - lon1) * Math.PI) / 180;
      const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos((lat1 * Math.PI) / 180) *
        Math.cos((lat2 * Math.PI) / 180) *
        Math.sin(dLon / 2) *
        Math.sin(dLon / 2);
      const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
      return R * c;
    }

    let map;

    function initMap() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          function (position) {
            const userLocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude,
            };

            const destination = {
              lat: parseFloat("{{ $toilet->latitude }}"),
              lng: parseFloat("{{ $toilet->longitude }}"),
            };

            map = new google.maps.Map(document.getElementById("map"), {
              center: userLocation,
              zoom: 14,
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
                { elementType: "labels.icon", stylers: [{ visibility: "off" }] },
              ],
            });

            // Render directions
            const directionsService = new google.maps.DirectionsService();
            const directionsRenderer = new google.maps.DirectionsRenderer();
            directionsRenderer.setMap(map);

            const request = {
              origin: userLocation,
              destination: destination,
              travelMode: "WALKING",
            };

            directionsService.route(request, function (result, status) {
              if (status === "OK") {
                directionsRenderer.setDirections(result);
              } else {
                alert("Could not load directions.");
              }
            });

            // Add markers
            new google.maps.Marker({
              position: userLocation,
              map,
              title: "You are here",
              icon: "https://maps.google.com/mapfiles/ms/icons/blue-dot.png",
            });

            new google.maps.Marker({
              position: destination,
              map,
              title: "{{ $toilet->name }}",
              //icon: "https://maps.google.com/mapfiles/ms/icons/red-dot.png",
            });

            // Watch user position continuously
            navigator.geolocation.watchPosition(
              function (pos) {
                const userLat = pos.coords.latitude;
                const userLng = pos.coords.longitude;

                const dist = getDistanceFromLatLonInMeters(
                  userLat,
                  userLng,
                  destination.lat,
                  destination.lng
                );

                const iveReachedBtn = document.getElementById("iveReachedBtn");

                if (dist <= 100) {
                  iveReachedBtn.disabled = false;
                  iveReachedBtn.classList.remove("opacity-50", "cursor-not-allowed");
                } else {
                  iveReachedBtn.disabled = true;
                  iveReachedBtn.classList.add("opacity-50", "cursor-not-allowed");
                }

                // Optional: update map center to user location as they move
                map.setCenter({ lat: userLat, lng: userLng });
              },
              function () {
                document.getElementById("map").innerHTML = `<p class="text-red-500 p-4">Location access denied.</p>`;
              }
            );
          },
          function () {
            document.getElementById("map").innerHTML = `<p class="text-red-500 p-4">Location access denied.</p>`;
          }
        );
      } else {
        document.getElementById("map").innerHTML = `<p class="text-red-500 p-4">Geolocation not supported by your browser.</p>`;
      }
    }
  </script>

  <script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_FRONTEND_KEY') }}I&callback=initMap"></script>
</body>

</html>