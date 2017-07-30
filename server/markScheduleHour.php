<?php
	ini_set('display_errors', '0');
	session_start();
	if(!isset($_SESSION['user'])){
		header('Location: ../index.html' );
		return;
	}

	if(isset($_POST["schedule_id"])){
		
		$schedule_id = $_POST["schedule_id"];
		
		$password = password_hash($password, PASSWORD_DEFAULT);
		
		include('./server_info.php');

		$conn = new mysqli($databaseHost, $user, $pass, $database);
		if ($conn->connect_error) {
			header("HTTP/1.1 500 Internal Server Error");
			echo "Connection failed: " . $conn->connect_error;
			return;
		}
		
		$sql = "UPDATE Schedules SET done=1 WHERE id='$schedule_id'";
		
		if ($conn->multi_query($sql) === TRUE) {

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