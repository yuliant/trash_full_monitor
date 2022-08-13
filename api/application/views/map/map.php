<?php 
if($idp == ''){
    
}else{
$data = $this->db->query("SELECT * FROM gps WHERE ID_PENGGUNA = '$idp' ORDER BY IDGPS DESC LIMIT 1")->result();
foreach ($data as $dt) {
	$lat = $dt->LATITUDE;
	$long = $dt->LONGTITUDE;
}
}

?>
<style>
	#map { position: absolute; top: 0; bottom: 0; width: 97%; height:600px;}
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

// var marker2 = new mapboxgl.Marker({
// color: "blue",
// draggable: false
// }).setLngLat([112.808304, -7.275973])
// .addTo(map); 
 
var layerList = document.getElementById('menu');
 
function switchLayer(layer) {
var layerId = layer.target.id;
map.setStyle('mapbox://styles/mapbox/' + layerId);
}

</script>
