<?php
	ini_set('display_errors', '0');
	session_start();
	if(!isset($_SESSION['user'])){
		header('Location: ../index.html' );
		return;
	}

	$client = $_SESSION["id"];
	
	include('./server_info.php');

	$conn = new mysqli($databaseHost, $user, $pass, $database);
	if ($conn->connect_error) {
		header("HTTP/1.1 500 Internal Server Error");
		echo "Connection failed: " . $conn->connect_error;
		return;
	}
	
	$whereConditions = "";
	if($client != -1){
		$whereConditions = "client_id = ".$client." AND";
	}
	
	$arr = array();
	$j = 0;
	
	$sql = "SELECT id, day_schedule, obs FROM Schedules WHERE $whereConditions valid=1 AND done != 1 AND day_schedule >= CURRENT_TIMESTAMP AND day_schedule <= DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 1 MONTH), '%Y-%m-%d')";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$arr[$j]["id"] = $row["id"];
			$arr[$j]["day"] = explode(" ", $row["day_schedule"])[0];
			$arr[$j]["hour"] = explode(" ", $row["day_schedule"])[1];
			$arr[$j]["dayOfWeek"] = date('l', strtotime($arr[$j]["day"]));
			$arr[$j]["obs"] = $row["obs"];
			$j++;
		}
	}
	
	$conn->close();
	
	usort($arr, function($a, $b) {
		if(strcmp($a['day'], $b['day']) == 0)
			return strcmp($a['hour'], $b['hour']);
		return strcmp($a['day'], $b['day']);
	});
	
	header("HTTP/1.1 200 OK");
	echo json_encode($arr);
	return;
?>