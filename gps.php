<?php
//error: Google Maps JavaScript API error: ApiNotActivatedMapError
//solution: click "APIs and services" Link
//			click "Enable APIs and services" button
//			Select "Maps JavaScript API" then click on enable

require 'functions.php';

// session_start();

// $conn = mysqli_connect("localhost", "root", "", "db_monitor");

// define('GOOGLE_MAP_API_KEY', 'AIzaSyAFRhCcfzENPIhfaYeLJS8Ww8d91jeg3cg');

$sql = "SELECT * FROM tb_location WHERE lct_id = 1002";
$result = $conn->query($sql);
if (!$result) {
  { echo "Error: " . $sql . "<br>" . $conn->error; }
}

$row = $result->fetch_assoc();
// var_dump($row);die;
//$rows = $result -> fetch_all(MYSQLI_ASSOC);

//print_r($row);

//header('Content-Type: application/json');
//echo json_encode($rows);


?>
<html>
<head>
<title>AhmadLogs - Show Locations in Google Maps</title>
</head>
<style>
body {
	font-family: Arial;
}

#map-layer {
	margin: 20px 0px;
	max-width: 700px;
	min-height: 400;
    border: 1px solid red;
}
</style>
<body>
	<h1>AhmadLogs - Show Locations in Google Maps</h1>
	<div id="map-layer"></div>
    <p>awal frame</p>
    <!-- <iframe src="https://www.google.com/maps?q=<?= $row['lct_lat']; ?>,<?= $row['lct_lng']; ?>&hl=es;z=14&output=embed" frameborder="0"></iframe> -->
    <iframe src="https://www.google.com/maps?q=-33.890541,151.274857&hl=es;z=14&output=embed" frameborder="0"></iframe>
    <p>akhir frame</p>

	<!-- <script
		src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAP_API_KEY;?>&callback=initMap"
		async defer></script>
        
    <script>
      var map;
      function initMap() {
        
        var mapLayer = document.getElementById("map-layer");
        var centerCoordinates = new google.maps.LatLng(<?php echo $row['lct_lat']; ?>, <?php echo $row['lct_lng']; ?>);
        var defaultOptions = { center: centerCoordinates, zoom: 10 }

        map = new google.maps.Map(mapLayer, defaultOptions);


      <?php while($row = $result->fetch_assoc()){ ?>
        var location = new google.maps.LatLng(<?php echo $row['lct_lat']; ?>, <?php echo $row['lct_lng']; ?>);
        var marker = new google.maps.Marker({
            position: location,
            map: map
        });
      <?php } ?>
        
      }
  </script> -->
</body>
</html>