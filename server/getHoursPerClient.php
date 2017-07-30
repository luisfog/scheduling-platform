<?php
	ini_set('display_errors', '0');
	session_start();
	if(!isset($_SESSION['user'])){
		header('Location: ../index.html' );
		return;
	}
	
	function hourAvailable($day, $hour, $array) {
		if($hour < 10)
			$scheduled = "$day 0$hour:00:00";
		else
			$scheduled = "$day $hour:00:00";
		for ($i = 0; $i < sizeof($array); $i++) {
			if($array[$i] == $scheduled){
				return false;
			}
		}
		return true;
	}
	
	$client = $_SESSION["id"];
	
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
	
	$arrMarked = array();
	$j = 0;
	
	$sql = "select day_schedule from Schedules where day_schedule >= CURRENT_TIMESTAMP AND day_schedule <= DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 1 MONTH), '%Y-%m-%d')";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$arrMarked[$j++] = $row["day_schedule"];
		}
	}
	
	$arrForever = array();
	$j = 0;
	
	$sql = "SELECT * FROM (";
	$sql .= " SELECT Hours.id, repeat_forever, days_available as day, hour_available, user_name FROM Hours, Clients WHERE Hours.available_for = Clients.id AND Hours.valid = 1 AND repeat_forever = 1 $whereConditions";
	$sql .= " UNION";
	$sql .= " SELECT id, repeat_forever, days_available as day, hour_available, available_for as user_name FROM Hours WHERE available_for = -1 AND valid = 1 AND repeat_forever = 1";
	$sql .= " ) as t ORDER BY repeat_forever, day, hour_available";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$arrForever[$j]["id"] = $row["id"];
			$arrForever[$j]["day"] = $row["day"];
			$arrForever[$j++]["hour"] = $row["hour_available"];
		}
	}
	
	$arr = array();
	$i = 0;
	
	$daysWeek = ["Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado", "Domingo"];
	
	$date = new DateTime();
	for ($k = 0; $k < 30; $k++) {
		for ($v = 0; $v < sizeof($arrForever); $v++) {
			if(($date->format("w")-1) == $arrForever[$v]["day"]){
				if(hourAvailable($date->format('Y-m-d'), $arrForever[$v]["hour"], $arrMarked)){
					$arr[$i]["id"] = $arrForever[$v]["id"];
					$arr[$i]["day"] = $date->format('Y-m-d');
					$arr[$i]["dayOfWeek"] = $daysWeek[date('N', strtotime($date->format('Y-m-d')))-1];
					$arr[$i++]["hour"] = $arrForever[$v]["hour"];
				}
			}
		}
		$date->add(new DateInterval('P1D'));
	}
	
	$sql = "SELECT * FROM (";
	$sql .= " SELECT Hours.id, repeat_forever, day_available as day, hour_available, user_name FROM Hours, Clients WHERE Hours.available_for = Clients.id AND Hours.valid = 1 AND repeat_forever = 0 AND day_available >= DATE_FORMAT(NOW(), '%Y-%m-%d') AND day_available <= DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 1 MONTH), '%Y-%m-%d') $whereConditions";
	$sql .= " UNION";
	$sql .= " SELECT id, repeat_forever, day_available as day, hour_available, available_for as user_name FROM Hours WHERE Hours.available_for = -1 AND valid = 1 AND repeat_forever = 0 AND day_available >= DATE_FORMAT(NOW(), '%Y-%m-%d') AND day_available <= DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 1 MONTH), '%Y-%m-%d')";
	$sql .= " ) as t ORDER BY repeat_forever, day, hour_available";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			if(hourAvailable($row["day"], $row["hour_available"], $arrMarked)){
				$arr[$i]["id"] = $row["id"];
				$arr[$i]["day"] = $row["day"];
				$arr[$i]["dayOfWeek"] = $daysWeek[date('N', strtotime($row["day"]))-1];
				$arr[$i++]["hour"] = $row["hour_available"];
			}
		}
	}
	
	$conn->close();
	
	usort($arr, function($a, $b) {
		if(strcmp($a['day'], $b['day']) == 0)
			return $a['hour'] - $b['hour'];
		return strcmp($a['day'], $b['day']);
	});
	
	header("HTTP/1.1 200 OK");
	echo json_encode($arr);
	return;
?>