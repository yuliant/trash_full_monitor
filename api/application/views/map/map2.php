<?php 
$data = $this->db->query("SELECT * FROM gps GROUP BY ID_PENGGUNA ORDER BY IDGPS ASC")->result();
 

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
zoom: 11,
center: [112.667542, -7.472613]
});


var marker = new mapboxgl.Marker({
color: "red"
}).setLngLat([112.667542, -7.472613]).setPopup(new mapboxgl.Popup().setHTML("")) // add popup
.addTo(map); 
<?php 
 foreach($data as $dt){
     echo $lg = $dt->LONGTITUDE;
     echo $lat = $dt->LATITUDE;
     echo $id = $dt->ID_PENGGUNA;?>
     var marker = new mapboxgl.Marker({
color: "red"
}).setLngLat([112.667542, -7.472613]).setPopup(new mapboxgl.Popup().setHTML("")) // add popup
.addTo(map); 
<?php
 }
?>

</script>
