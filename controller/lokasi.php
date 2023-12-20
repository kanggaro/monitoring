<?php  
// lokasi

require '../functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = $_POST['api_key'];

	if($api_key == 'WMT-16-PKT') {
		$latitude = escape_data($_POST["lat"]);
		$longitude = escape_data($_POST["lng"]);
		$nomesin = escape_data($_POST["nomesin"]);
		
		// $sql = "INSERT INTO tb_location(lct_lat, lct_lng, lct_date, tb_mesin_msn_id) 
		// 			VALUES('$latitude', '$longitude', ''".date("Y-m-d H:i:s")."'', '$nomesin' )";

		$query = "UPDATE tb_location SET
						lct_lat = '$latitude', 
						lct_lng = '$longitude'
					WHERE tb_mesin_msn_id = '$nomesin'";

		if($conn->query($query) === FALSE)
			{ echo "Error: " . $query . "<br>" . $conn->error; }

		mysqli_query($conn, $query);

		return mysqli_query($conn, $query);   
	}
	else
	{
		echo "Wrong API Key";
	}

}

function escape_data($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>