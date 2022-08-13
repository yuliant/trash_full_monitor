<!-- Begin Page Content -->
<div class="container-fluid">
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

$(this).ready(function(){
	setInterval(function(){
		$("#map").load('<?= base_url('supervisor/getgps/map/') . $id_pengguna ?>')
    }, 10000);
});
</script>
<div id="map"></div>
        <!--<div id="map"></div>-->
</div>
</div>
</div>

</div>