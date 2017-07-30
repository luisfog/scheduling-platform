<?php
	ini_set('display_errors', '0');
	session_start();
	if(!isset($_SESSION['user']) || strcmp($_SESSION['id'], "-1") !== 0){
		header('Location: ../index.html' );
		return;
	}
	
	include('./server_info.php');

	$conn = new mysqli($databaseHost, $user, $pass, $database);
	if ($conn->connect_error) {
		header("HTTP/1.1 500 Internal Server Error");
		echo "Connection failed: " . $conn->connect_error;
		return;
	}
	
	$sql = "SELECT id, name, user_name, email, phone FROM Clients WHERE valid = 1 ORDER BY name";
	$result = $conn->query($sql);
	
	$arr = array();
	$i = 0;
	
	if ($result->num_rows > 0) {
		if(isset($_POST["type"]) && $_POST["type"] == "short"){
			while($row = $result->fetch_assoc()) {
				$arr[$i]["id"] = $row["id"];
				$arr[$i++]["user_name"] = $row["user_name"];
			}
		}else{
			while($row = $result->fetch_assoc()) {
				$arr[$i]["id"] = $row["id"];
				$arr[$i]["name"] = $row["name"];
				$arr[$i]["user_name"] = $row["user_name"];
				$arr[$i]["email"] = $row["email"];
				$arr[$i++]["phone"] = $row["phone"];
			}
		}
	}
	
	$conn->close();
	
	header("HTTP/1.1 200 OK");
	echo json_encode($arr);
	return;
?>