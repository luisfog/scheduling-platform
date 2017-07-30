<?php
	ini_set('display_errors', '0');
	session_start();
	if(!isset($_SESSION['user']) || strcmp($_SESSION['id'], "-1") !== 0){
		header('Location: ../index.html' );
		return;
	}

	if(isset($_POST["user_name"]) && isset($_POST["email"])){
		
		include('./contactClient.php');
		
		$user_name = $_POST["user_name"];
		$email = $_POST["email"];
		
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$count = mb_strlen($chars);

		for ($i = 0, $passwordRaw = ''; $i < 8; $i++) {
			$index = rand(0, $count - 1);
			$passwordRaw .= mb_substr($chars, $index, 1);
		}
	
		$password = password_hash($passwordRaw, PASSWORD_DEFAULT);
		
		include('./server_info.php');

		$conn = new mysqli($databaseHost, $user, $pass, $database);
		if ($conn->connect_error) {
			header("HTTP/1.1 500 Internal Server Error");
			echo "Connection failed: " . $conn->connect_error;
			return;
		}
				
		$sql = "UPDATE Clients SET password='$password' WHERE user_name='$user_name'";
		
		if ($conn->multi_query($sql) === TRUE) {
			
			sendMail($email, "Password reseted in Scheduling Platform", "Your password has been reseted in the Scheduling Platform\nUser: $user_name\nPassword: $passwordRaw");
	
			header("HTTP/1.1 200 OK");
			$conn->close();
			return;
		} else {
			header("HTTP/1.1 500 Internal Server Error");
			echo "Not enough data.";
			$conn->close();
			return;
		}
	}
	
	header("HTTP/1.1 500 Internal Server Error");
	echo "Not enough data.";
	return;
?>