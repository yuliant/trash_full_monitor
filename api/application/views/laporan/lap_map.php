<?php 
// $data = $this->db->query("SELECT * FROM gps GROUP BY ID_PENGGUNA ORDER BY IDGPS ASC")->result();
 
$long = $longlat['LONGTITUDE'];
$lat = $longlat['LATITUDE'];
?>
<script src="https://api.mapbox.com/mapbox-gl-js/v2.0.1/mapbox-gl.js"></script>
<link href="https://api.mapbox.com/mapbox-gl-js/v2.0.1/mapbox-gl.css" rel="stylesheet" />
<script src="https://unpkg.com/es6-promise@4.2.4/dist/es6-promise.auto.min.js"></script>
<script src="https://unpkg.com/@mapbox/mapbox-sdk/umd/mapbox-sdk.min.js"></script>
<style>
    #map { position: absolute; top: 0; bottom: 0; width: 100%; height:100%;}
</style>

<div id="map"></div>
<script src="https://unpkg.com/es6-promise@4.2.4/dist/es6-promise.auto.min.js"></script>
<script src="https://unpkg.com/@mapbox/mapbox-sdk/umd/mapbox-sdk.min.js"></script>

<script>
mapboxgl.accessToken = 'pk.eyJ1IjoicGlqYXJkd2kiLCJhIjoiY2s4cXljenF2MDJxYzNmcXpwejB3ZnB3eCJ9.2wIDYehxqp_mJbtp83ISLg';
var map = new mapboxgl.Map({
container: 'map',
style: 'mapbox://styles/pijardwi/ckkljgfyt3u8j17nssbdnamhj',
zoom: 17,
center: [<?php echo $long;?>, <?php echo $lat;?>]
});
 
var marker = new mapboxgl.Marker({
color: "red",
draggable: false
}).setLngLat([<?php echo $long;?>, <?php echo $lat;?>])
.addTo(map); 

 
var layerList = document.getElementById('menu');
 
function switchLayer(layer) {
var layerId = layer.target.id;
map.setStyle('mapbox://styles/mapbox/' + layerId);
}

</script>