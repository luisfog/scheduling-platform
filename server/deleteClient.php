<?php
	ini_set('display_errors', '0');
	session_start();
	if(!isset($_SESSION['user']) || strcmp($_SESSION['id'], "-1") !== 0){
		header('Location: ../index.html' );
		return;
	}

	if(isset($_POST["user_name"])){
		
		$user_name = $_POST["user_name"];
		
		$password = password_hash($password, PASSWORD_DEFAULT);
		
		include('./server_info.php');

		$conn = new mysqli($databaseHost, $user, $pass, $database);
		if ($conn->connect_error) {
			header("HTTP/1.1 500 Internal Server Error");
			echo "Connection failed: " . $conn->connect_error;
			return;
		}
		
		$milliseconds = round(microtime(true) * 1000);
		$sql = "UPDATE Clients SET user_name='".$user_name."_".$milliseconds."', valid=0, delete_date=NOW() WHERE user_name LIKE '$user_name'";
		
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