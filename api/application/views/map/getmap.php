<!-- Begin Page Content -->
<div class="container-fluid">
<?php 
//$data = $this->db->query("SELECT * FROM gps ORDER BY IDGPS DESC LIMIT 1")->result();
foreach ($datamap as $dt) {
	echo $lat = $dt->LATITUDE;
	echo $long = $dt->LONGTITUDE;
}

?>
<script src="https://api.mapbox.com/mapbox-gl-js/v2.0.1/mapbox-gl.js"></script>
<link href="https://api.mapbox.com/mapbox-gl-js/v2.0.1/mapbox-gl.css" rel="stylesheet" />
<script src="https://unpkg.com/es6-promise@4.2.4/dist/es6-promise.auto.min.js"></script>
<script src="https://unpkg.com/@mapbox/mapbox-sdk/umd/mapbox-sdk.min.js"></script>

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title; ?></h1>
    <div class="row">
        <div class="col-lg-12">
            <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script>
// window.onload = function () {
//     someFunction();
// }


// function someFunction() {
//     //var seconds_left = 10;
//     var interval = setInterval(function () {
//         //document.getElementById('aasd').innerHTML = "Or wait " + --seconds_left + " seconds to view the map.";
//         //if (seconds_left <= 0) {
//             //alert('The video is ready to play.');
//             $("#aasd").load('getmap/map')
//             $('#def').fadeOut('slow');
//             //clearInterval(interval);
//             //Interval = 10;
//         //}
//     }, 1000);
// }
$(this).ready(function(){
	setInterval(function(){
	    //alert('endi eror e');
		$("#map").load('getgps/map')
    }, 10000);
});
</script>
<div id="map"></div>
        <!--<div id="map"></div>-->
</div>
</div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->