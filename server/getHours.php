<?php
	ini_set('display_errors', '0');
	session_start();
	if(!isset($_SESSION['user']) || strcmp($_SESSION['id'], "-1") !== 0){
		header('Location: ../index.html' );
		return;
	}
	
	if(isset($_POST["client_id"]) && isset($_POST["type"])){
	
		$client = $_POST["client_id"];
		$type = $_POST["type"];
		
		include('./server_info.php');

		$conn = new mysqli($databaseHost, $user, $pass, $database);
		if ($conn->connect_error) {
			header("HTTP/1.1 500 Internal Server Error");
			echo "Connection failed: " . $conn->connect_error;
			return;
		}
		
		$whereConditions = "";
		if($client != -1){
			$whereConditions = "AND Clients.id = ".$client;
		}
		
		$arr = array();
		$i = 0;
		
		$sql = "SELECT * FROM (";
		if($type != 2){
			$sql .= " SELECT Hours.id, repeat_forever, days_available as day, hour_available, user_name FROM Hours, Clients WHERE Hours.available_for = Clients.id AND Hours.valid = 1 AND repeat_forever = 1 $whereConditions";
			$sql .= " UNION";
			$sql .= " SELECT id, repeat_forever, days_available as day, hour_available, available_for as user_name FROM Hours WHERE available_for = -1 AND valid = 1 AND repeat_forever = 1";
		}
		if($type == 0){
			$sql .= " UNION";
		}
		if($type != 1){
			$sql .= " SELECT Hours.id, repeat_forever, day_available as day, hour_available, user_name FROM Hours, Clients WHERE Hours.available_for = Clients.id AND Hours.valid = 1 AND repeat_forever = 0 AND day_available >= DATE_FORMAT(NOW(), '%Y-%m-%d') $whereConditions";
			$sql .= " UNION";
			$sql .= " SELECT id, repeat_forever, day_available as day, hour_available, available_for as user_name FROM Hours WHERE Hours.available_for = -1 AND valid = 1 AND repeat_forever = 0 AND day_available >= DATE_FORMAT(NOW(), '%Y-%m-%d')";
		}
		$sql .= " ) as t ORDER BY repeat_forever, day, hour_available";
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$arr[$i]["id"] = $row["id"];
				$arr[$i]["repeat"] = $row["repeat_forever"];
				$arr[$i]["day"] = $row["day"];
				$arr[$i]["hour"] = $row["hour_available"];
				$arr[$i++]["client"] = $row["user_name"];
			}
		}
		
		$conn->close();
		
		header("HTTP/1.1 200 OK");
		echo json_encode($arr);
		return;
	}
	
	header("HTTP/1.1 500 Internal Server Error");
	echo "Not enough data.";
	return;
?>