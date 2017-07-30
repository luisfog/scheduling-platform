<?php
	ini_set('display_errors', '0');
	session_start();
	if(!isset($_SESSION['user']) || strcmp($_SESSION['id'], "-1") !== 0){
		header('Location: ../index.html' );
		return;
	}
	
	if(isset($_POST["client_id"]) && isset($_POST["when"])){
	
		$client = $_POST["client_id"];
		$when = $_POST["when"];
		
		include('./server_info.php');

		$conn = new mysqli($databaseHost, $user, $pass, $database);
		if ($conn->connect_error) {
			header("HTTP/1.1 500 Internal Server Error");
			echo "Connection failed: " . $conn->connect_error;
			return;
		}
		
		$whereConditions = "";
		if($client != -1){
			$whereConditions = "client_id = ".$client." AND ";
		}
		if($when == "today"){
			$whereConditions = "done != 1 AND day_schedule >= NOW() AND day_schedule < DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 1 DAY), '%Y-%m-%d')";
		}
		if($when == "tomorrow"){
			$whereConditions = "done != 1 AND day_schedule >= DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 1 DAY), '%Y-%m-%d') AND day_schedule < DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 2 DAY), '%Y-%m-%d')";
		}
		if($when == "10days"){
			$whereConditions = "done != 1 AND day_schedule >= NOW() AND day_schedule <= DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 10 DAY), '%Y-%m-%d')";
		}
		if($when == "30days"){
			$whereConditions = "done != 1 AND day_schedule >= NOW() AND day_schedule <= DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 30 DAY), '%Y-%m-%d')";
		}
		if($when == "last30days"){
			$whereConditions = "done = 1 AND day_schedule >= DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -30 DAY), '%Y-%m-%d') AND day_schedule <= NOW()";
		}
		
		$arr = array();
		$j = 0;
		
		$sql = "SELECT Schedules.id, day_schedule, name, user_name, email, phone, obs FROM Schedules, Clients WHERE Schedules.valid=1 AND client_id = Clients.id AND $whereConditions";
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$arr[$j]["id"] = $row["id"];
				$arr[$j]["day"] = explode(" ", $row["day_schedule"])[0];
				$arr[$j]["hour"] = explode(" ", $row["day_schedule"])[1];
				$arr[$j]["dayOfWeek"] = date('l', strtotime($arr[$j]["day"]));
				$arr[$j]["obs"] = $row["obs"];
				$arr[$j]["client_name"] = $row["name"];
				$arr[$j]["client_user"] = $row["user_name"];
				$arr[$j]["client_email"] = $row["email"];
				$arr[$j++]["client_phone"] = $row["phone"];
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
	}
	
	header("HTTP/1.1 500 Internal Server Error");
	echo "Not enough data.";
	return;
?>