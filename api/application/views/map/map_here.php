
  <?php 
if($idp == ''){
      
}else{
  for ($i=0; $i < 1000; $i++) { 
    # code...
    $data = $this->db->query("SELECT * FROM gps WHERE ID_PENGGUNA = '$idp' ORDER BY IDGPS DESC LIMIT 1")->result();

    $lat = "";
    $long = "";
    foreach ($data as $dt) {
        $lat = $dt->LATITUDE;
        $long = $dt->LONGTITUDE;

    }
  }
}

?>
<!-- Begin Page Content -->
<div class="container-fluid">
<!-- <script src="https://api.mapbox.com/mapbox-gl-js/v2.0.1/mapbox-gl.js"></script>
<link href="https://api.mapbox.com/mapbox-gl-js/v2.0.1/mapbox-gl.css" rel="stylesheet" /> -->
<script src="https://unpkg.com/es6-promise@4.2.4/dist/es6-promise.auto.min.js"></script>
<!-- <script src="https://unpkg.com/@mapbox/mapbox-sdk/umd/mapbox-sdk.min.js"></script> -->

<link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />
<style type="text/css">  
  #map {
      width: 95%;
      height: 450px;
      background: grey;
  }

  #panel {
      width: 100%;
      height: 400px;
  }
</style>

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title; ?></h1>
    <div class="row">
        <div class="col-lg-12">
            <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>

<!-- <script>
$(this).ready(function(){
  setInterval(function(){
    $("#map").load('<?= base_url("supervisor/Getgps/map/".$id_pengguna); ?>');
    }, 1000);
});
</script> -->
<body id="markers-on-the-map">
    
    <div class="page-header">
    <div id="map"></div>
    <!-- <script type="text/javascript" src='app.js'></script> -->

  </body>
<!-- <div id="map"></div> -->
</div>

</div>
</div>

</div>
  
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-core.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-service.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"></script>
    <script type="text/javascript">
        // Initialize the platform object:
// $(document).ready(function(){

// })
  var platform = new H.service.Platform({
    apikey: "m-UC4gmBTDuMyf2Mhgb9ABkwXCvZvo2cDPiFfr7bJN8"
  });

  var defaultLayers = platform.createDefaultLayers();
  // Instantiate (and display) a map object:
  var map = new H.Map(document.getElementById('map'),
    defaultLayers.vector.normal.map,{
    center: {lat:'<?php echo $lat;?>', lng:'<?php echo $long;?>'},
    zoom: 15,
    pixelRatio: window.devicePixelRatio || 1
  });
  // add a resize listener to make sure that the map occupies the whole container
  window.addEventListener('resize', () => map.getViewPort().resize());

  //Step 3: make the map interactive
  // MapEvents enables the event system
  // Behavior implements default interactions for pan/zoom (also on mobile touch environments)
  var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));

  // Create the default UI components
  var ui = H.ui.UI.createDefault(map, defaultLayers);

  // Now use the map as required...
  window.onload = function () {
    addMarkersToMap(map);
  }

function addMarkersToMap(map) {

    var parisMarker = new H.map.Marker({lat:'<?php echo $lat;?>', lng:'<?php echo $long;?>'});
    map.addObject(parisMarker);

//     var romeMarker = new H.map.Marker({lat:41.9, lng: 12.5});
//     map.addObject(romeMarker);

//     var berlinMarker = new H.map.Marker({lat:52.5166, lng:13.3833});
//     map.addObject(berlinMarker);

//     var madridMarker = new H.map.Marker({lat:40.4, lng: -3.6833});
//     map.addObject(madridMarker);

//     var londonMarker = new H.map.Marker({lat:51.5008, lng:-0.1224});
//     map.addObject(londonMarker);
}
  
$(this).ready(function(){
  setInterval(function(){
  // $.get("data_here.html", function(data){
  //     // var mydata= $.parseJSON(data);
  //     // var art1 = mydata.key1;  // <-----------  access the element
  //     alert(data);
  //   });
  // $.ajax({
  //   type:"GET",
  //   url:"data_here.html",

  // });
    }, 3000);
});
// setTimeout(function () {
  
// }, 2000)
// Obtain the default map types from the platform object
// var maptypes = platform.createDefaultLayers();

    </script>
