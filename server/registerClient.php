<?php
	ini_set('display_errors', '0');
	session_start();
	if(!isset($_SESSION['user']) || strcmp($_SESSION['id'], "-1") !== 0){
		header('Location: ../index.html' );
		return;
	}
	
	if(isset($_POST["name"]) && isset($_POST["user_name"]) && isset($_POST["email"]) && isset($_POST["phone"])){

		include('./contactPerson.php');
		
		$name = $_POST["name"];
		$user_name = $_POST["user_name"];
		$email = $_POST["email"];
		$phone = $_POST["phone"];
		
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
				
		$sql = "INSERT INTO Clients(name,user_name,password,email,phone) VALUES ('$name','$user_name','$password','$email','$phone')";
		
		if ($conn->multi_query($sql) === TRUE) {
			
			$subject = "Registered in Scheduling Platform";
			$message = "You have been registered in the Scheduling Platform: www.$domain\nUser: $user_name\nPassword: $passwordRaw";
			sendMail($to_name,"no-reply@$domain", $name, $email, $subject, $message);

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