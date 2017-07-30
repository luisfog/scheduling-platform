<?php
	ini_set('display_errors', '0');
	session_start();
	if(!isset($_SESSION['user']) || strcmp($_SESSION['id'], "-1") !== 0){
		header('Location: ../index.html' );
		return;
	}
	
	if(isset($_POST["repeat"]) && isset($_POST["day"]) && isset($_POST["hour"]) && isset($_POST["who"])){

		include('./contactClient.php');
		
		$repeat = $_POST["repeat"];
		$day = $_POST["day"];
		$hour = $_POST["hour"];
		$who = $_POST["who"];
		
		include('./server_info.php');

		$conn = new mysqli($databaseHost, $user, $pass, $database);
		if ($conn->connect_error) {
			header("HTTP/1.1 500 Internal Server Error");
			echo "Connection failed: " . $conn->connect_error;
			return;
		}
		
		if($repeat == 0)
			$sql = "INSERT INTO Hours(repeat_forever,day_available,hour_available,available_for)".
				"VALUES ($repeat,'$day',$hour,$who)";
		else	
			$sql = "INSERT INTO Hours(repeat_forever,days_available,hour_available,available_for)".
				"VALUES ($repeat,'$day',$hour,$who)";
		
		echo $sql;
		if ($conn->multi_query($sql) === TRUE) {
			
			sendMail($email, "Registered in Scheduling Platform", "You have been registered in the Scheduling Platform\nUser: $user_name\nPassword: $passwordRaw");
	
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