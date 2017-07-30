<?php
	ini_set('display_errors', '0');
	session_start();
	if(!isset($_SESSION['user'])){
		header('Location: ../index.html' );
		return;
	}

	if(isset($_POST["schedule_id"])){
		
		include('./contactPerson.php');
		
		$schedule_id = $_POST["schedule_id"];
		
		$password = password_hash($password, PASSWORD_DEFAULT);
		
		include('./server_info.php');

		$conn = new mysqli($databaseHost, $user, $pass, $database);
		if ($conn->connect_error) {
			header("HTTP/1.1 500 Internal Server Error");
			echo "Connection failed: " . $conn->connect_error;
			return;
		}
		
		$sql = "UPDATE Schedules SET valid=0, delete_date=NOW() WHERE id=$schedule_id";
		
		if ($conn->query($sql) === TRUE) {
			
			$sql ="SELECT day_schedule, Schedules.reg_date, name, email, obs FROM Schedules, Clients WHERE Schedules.id = $schedule_id AND client_id = Clients.id";
			$result = $conn->query($sql);
			
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				
				$timestamp = $row["day_schedule"];
				$obs = $row["obs"];
				$name = $row["name"];
				$reg_date = strtotime($row["reg_date"]);
				
				$startDate = strtotime($timestamp);
				$endDate = $startDate + 3600;
				
				$from_name = "no-reply";
				$from_address = "no-reply@".$domain;
				$startTime = $startDate;
				$endTime = $endDate;
				$subject = "$name - $obs";
				$description = "Schedulings Platform";
				$location = "";
				$uid = $startDate.$reg_date."@".$domain;
				
				cancelIcalEvent($uid, $from_name, $from_address, $to_name, $to_address, $startTime, $endTime, $subject, $description, $location);
			}
			
			header("HTTP/1.1 200 OK");
			$conn->close();
			return;
		} else {
			header("HTTP/1.1 500 Internal Server Error");
			echo "Error during delete.";
			$conn->close();
			return;
		}
	}
	
	header("HTTP/1.1 500 Internal Server Error");
	echo "Not enough data.";
	return;
?>