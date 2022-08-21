<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Maps - Trash Full Monitor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://api.tiles.mapbox.com/mapbox-gl-js/v2.9.2/mapbox-gl.js"></script>
    <link href="https://api.tiles.mapbox.com/mapbox-gl-js/v2.9.2/mapbox-gl.css" rel="stylesheet" />
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.min.js"></script>
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.css" type="text/css" />
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        #map {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>

<body>


    <div id="map"></div>

    <script>
        mapboxgl.accessToken = 'pk.eyJ1IjoicGlqYXJkd2kiLCJhIjoiY2s4cXljenF2MDJxYzNmcXpwejB3ZnB3eCJ9.2wIDYehxqp_mJbtp83ISLg';
        const map = new mapboxgl.Map({
            container: 'map', // Container ID
            style: 'mapbox://styles/pijardwi/ckkljgfyt3u8j17nssbdnamhj', // Map style to use
            center: [<?= $tempat_sampah->LATITUDE ?>, <?= $tempat_sampah->LONGITUDE ?>], // Starting position [lng, lat]
            zoom: 17 // Starting zoom level
        });

        const marker = new mapboxgl.Marker() // Initialize a new marker
            .setLngLat([<?= $tempat_sampah->LATITUDE ?>, <?= $tempat_sampah->LONGITUDE ?>]) // Marker [lng, lat] coordinates
            .addTo(map); // Add the marker to the map

        const geocoder = new MapboxGeocoder({
            // Initialize the geocoder
            accessToken: mapboxgl.accessToken, // Set the access token
            mapboxgl: mapboxgl, // Set the mapbox-gl instance
            marker: false, // Do not use the default marker style
            placeholder: 'Search for in this place', // Placeholder text for the search bar
            // bbox: [
            //     <?= $tempat_sampah->LONGITUDE  ?>,
            //     <?= $tempat_sampah->LATITUDE ?>,
            //     <?= $tempat_sampah->LONGITUDE  ?>,
            //     <?= $tempat_sampah->LATITUDE ?>
            // ], // Boundary for Berkeley
            proximity: {
                longitude: <?= $tempat_sampah->LONGITUDE ?>,
                latitude: <?= $tempat_sampah->LATITUDE ?>
            } // Coordinates of UC Berkeley
        });

        // Add the geocoder to the map
        map.addControl(geocoder);

        // After the map style has loaded on the page,
        // add a source layer and default styling for a single point
        map.on('load', () => {
            map.addSource('single-point', {
                'type': 'geojson',
                'data': {
                    'type': 'FeatureCollection',
                    'features': []
                }
            });

            map.addLayer({
                'id': 'point',
                'source': 'single-point',
                'type': 'circle',
                'paint': {
                    'circle-radius': 10,
                    'circle-color': '#448ee4'
                }
            });

            // Listen for the `result` event from the Geocoder // `result` event is triggered when a user makes a selection
            //  Add a marker at the result's coordinates
            geocoder.on('result', (event) => {
                map.getSource('single-point').setData(event.result.geometry);
            });
        });
    </script>
</body>

</html>