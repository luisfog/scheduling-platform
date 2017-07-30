<?php
	ini_set('display_errors', '0');
	session_start();
	if(!isset($_SESSION['user'])){
		header('Location: ../index.html' );
		return;
	}

	if(isset($_POST["hour_id"]) && isset($_POST["timestamp"]) && isset($_POST["obs"])){

		include('./contactPerson.php');
		
		$client_id = $_SESSION["id"];
		$hour_id = $_POST["hour_id"];
		$timestamp = $_POST["timestamp"];
		$obs = $_POST["obs"];
		
		include('./server_info.php');

		$conn = new mysqli($databaseHost, $user, $pass, $database);
		if ($conn->connect_error) {
			header("HTTP/1.1 500 Internal Server Error");
			echo "Connection failed: " . $conn->connect_error;
			return;
		}
		
		$reg_date = time();
		
		$sql = "INSERT INTO Schedules(client_id,hour_id,day_schedule,obs,reg_date)".
				"VALUES ($client_id,$hour_id,'$timestamp','$obs','".date("Y-m-d H:i:s", $reg_date)."')";
				
		if ($conn->multi_query($sql) === TRUE) {
			
			$startDate = strtotime($timestamp);
			$endDate = $startDate + 3600;
			
			$from_name = "no-reply";
			$from_address = "no-reply@".$domain;
			$startTime = $startDate;
			$endTime = $endDate;
			$subject = $_SESSION["name"]." - $obs";
			$description = $obs;
			$location = "";
			$uid = $startDate.$reg_date."@".$domain;
			
			sendIcalEvent($uid, $from_name, $from_address, $to_name, $to_address, $startTime, $endTime, $subject, $description, $location);

			header("HTTP/1.1 200 OK");
			$conn->close();
			return;
			
		} else {
			header("HTTP/1.1 500 Internal Server Error");
			echo "Cannot register.";
			$conn->close();
			return;
		}
	}
	
	header("HTTP/1.1 500 Internal Server Error");
	echo "Not enough data.";
	return;
?>