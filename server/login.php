<?php
	ini_set('display_errors', '0');
	if(isset($_POST['username']) && isset($_POST['password'])){
		
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		include('./server_info.php');
		
		if(strcmp($username, $admin_user) !== 0){
			$conn = new mysqli($databaseHost, $user, $pass, $database);
			if ($conn->connect_error) {
				header('Location: ../index.html' );
				return;
			}
	
			$sql = "SELECT id, password, name FROM Clients WHERE user_name='$username'";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				$hash = $row["password"];
				$id = $row["id"];
				$name = $row["name"];
				
				if (password_verify($password, $hash)) {
					session_start();
					$_SESSION["user"] = $username;
					$_SESSION["name"] = $name;
					$_SESSION["id"] = $id;
					header('Location: ../clientZone.php' );
					return;
				} else {
					header('Location: ../index.html' );
					return;
				}
			}
		}else{
			if (password_verify($password, $admin_hash)) {
				session_start();
				$_SESSION["user"] = $username;
				$_SESSION["name"] = $to_name;
				$_SESSION["id"] = "-1";
				header('Location: ../clients.php' );
				return;
			} else {
				header('Location: ../index.html' );
				return;
			}
		}
	}
	header('Location: ../index.html' );
?>
