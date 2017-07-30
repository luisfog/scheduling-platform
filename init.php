<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" href="./img/favicon.ico">
	<title>Scheduling Platform</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="js/init.js"></script>
  </head>
  <body>

    <div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							 <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
						</button>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">
						</ul>
						<ul class="nav navbar-nav navbar-right">
							<li>
								<img src="./img/logo.png" class="logonav" />
							</li>
						</ul>
					</div>
				</nav>
			</div>
		</div>
		
		<br/><br/><br/><br/>
		
		<div class="row block">
			<div class="col-md-12">
				<h2 class="sectionTitle">
					Configure Scheduler Platform
				</h2>
				<form action="init.php" method="post">
					<div class="col-md-3 col-sm-3 col-xs-6 form-group has-feedback">
						<input type="text" class="form-control has-feedback-left" name="db_host" placeholder="Database host" />
						<span class="fa fa-database form-control-feedback left" aria-hidden="true"></span>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-6 form-group has-feedback">
						<input type="text" class="form-control has-feedback-left" name="db" placeholder="Database name" />
						<span class="fa fa-database form-control-feedback left" aria-hidden="true"></span>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-6 form-group has-feedback">
						<input type="text" class="form-control has-feedback-left" name="db_user" placeholder="Database User" />
						<span class="fa fa-database form-control-feedback left" aria-hidden="true"></span>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-6 form-group has-feedback">
						<input type="password" class="form-control has-feedback-left" name="db_password" placeholder="Database Password" />
						<span class="fa fa-database form-control-feedback left" aria-hidden="true"></span>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-6 form-group has-feedback">
						<input type="text" class="form-control has-feedback-left" name="name" placeholder="Admin Name" />
						<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-6 form-group has-feedback">
						<input type="text" class="form-control has-feedback-left" name="email" placeholder="Admin eMail" />
						<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-6 form-group has-feedback">
						<input type="text" class="form-control has-feedback-left" name="user" placeholder="Admin User" />
						<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-6 form-group has-feedback">
						<input type="password" class="form-control has-feedback-left" name="password" placeholder="Admin Password" />
						<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-6 form-group has-feedback">
						<input type="text" class="form-control has-feedback-left" name="domain" placeholder="Site Domain" />
						<span class="fa fa-link form-control-feedback left" aria-hidden="true"></span>
					</div>
					
					<div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
						<input type="submit" class="form-control button" value="Create Configuration" />
						<span class="fa fa-plus form-control-feedback left" aria-hidden="true" style="color:#fff;"></span>
					</div>
				</form>
			</div>
		</div>
		
<?php
	if( isset($_POST['db_host']) && isset($_POST['db']) && isset($_POST['db_user']) && isset($_POST['db_password']) &&
		isset($_POST['name']) && isset($_POST['email']) && isset($_POST['user']) && isset($_POST['password']) &&
		isset($_POST['domain'])){
		
		$db_host = $_POST["db_host"];
		$db = $_POST["db"];
		$db_user = $_POST["db_user"];
		$db_password = $_POST["db_password"];
		$name = $_POST["name"];
		$email = $_POST["email"];
		$user = $_POST["user"];
		$password = $_POST["password"];
		$domain = $_POST["domain"];
		
		$conn = new mysqli($db_host, $db_user, $db_password, $db);
		if ($conn->connect_error) {
			header("HTTP/1.1 500 Internal Server Error");
			echo "Connection failed: " . $conn->connect_error;
			return;
		}

		$sql = "CREATE TABLE Clients (
					id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					name VARCHAR(60) NOT NULL,
					user_name VARCHAR(30) NOT NULL,
					password VARCHAR(70) NOT NULL,
					email VARCHAR(70) NOT NULL,
					phone VARCHAR(20),
					reg_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
					delete_date TIMESTAMP NOT NULL DEFAULT 0,
					valid BIT DEFAULT 1,
					CONSTRAINT uc1 UNIQUE (user_name)
				)";
		if ($conn->query($sql) === TRUE) {
			echo "<br/><div class=\"row block\" style=\"background: #aaffbb;\">".
				"<div class=\"col-md-12\"><h3 class=\"sectionTitle\" style=\"color: #666\">".
				"Clients table created successfully</h3></div></div>";
		} else {
			echo "Error creating Clients table: " . $conn->error;
			$conn->close();
			return;
		}
		
		$sql = "CREATE TABLE Hours (
					id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					repeat_forever BIT NOT NULL,
					day_available VARCHAR(30),
					days_available TINYINT,
					hour_available TINYINT,
					available_for INT(6),
					reg_date TIMESTAMP  NOT NULL DEFAULT CURRENT_TIMESTAMP,
					delete_date TIMESTAMP NOT NULL DEFAULT 0,
					valid BIT DEFAULT 1
				)";
		if ($conn->query($sql) === TRUE) {
			echo "<br/><div class=\"row block\" style=\"background: #aaffbb;\">".
				"<div class=\"col-md-12\"><h3 class=\"sectionTitle\" style=\"color: #666\">".
				"Hours table created successfully</h3></div></div>";
		} else {
			echo "Error creating Hours table: " . $conn->error;
			$conn->close();
			return;
		}
		
		$sql = "CREATE TABLE Schedules (
					id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					client_id INT(6) NOT NULL,
					hour_id INT(6) NOT NULL,
					day_schedule TIMESTAMP NOT NULL DEFAULT 0,
					obs TEXT,
					done BIT DEFAULT 0,
					reg_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
					delete_date TIMESTAMP NOT NULL DEFAULT 0,
					valid BIT DEFAULT 1
				)";
		if ($conn->query($sql) === TRUE) {
			echo "<br/><div class=\"row block\" style=\"background: #aaffbb;\">".
				"<div class=\"col-md-12\"><h3 class=\"sectionTitle\" style=\"color: #666\">".
				"Schedules table created successfully</h3></div></div>";
		} else {
			echo "Error creating Schedules table: " . $conn->error;
			$conn->close();
			return;
		}
		
		$conn->close();
		
		file_put_contents("./server/server_info.php", "<?php\n", FILE_APPEND);
		file_put_contents("./server/server_info.php", "\$databaseHost = '".$db_host."';\n", FILE_APPEND);
		file_put_contents("./server/server_info.php", "\$database = '".$db."';\n", FILE_APPEND);
		file_put_contents("./server/server_info.php", "\$user = '".$db_user."';\n", FILE_APPEND);
		file_put_contents("./server/server_info.php", "\$pass = '".$db_password."';\n\n", FILE_APPEND);
		file_put_contents("./server/server_info.php", "\$to_name = '".$name."';\n", FILE_APPEND);
		file_put_contents("./server/server_info.php", "\$to_address = '".$email."';\n", FILE_APPEND);
		file_put_contents("./server/server_info.php", "\$domain = '".$domain."';\n\n", FILE_APPEND);
		file_put_contents("./server/server_info.php", "\$admin_user = '".$user."';\n", FILE_APPEND);
		file_put_contents("./server/server_info.php", "\$admin_hash = '".password_hash($password, PASSWORD_DEFAULT)."';\n", FILE_APPEND);
		file_put_contents("./server/server_info.php", "?>", FILE_APPEND);
		
		echo "<br/><div class=\"row block\" style=\"background: #aaffbb;\">".
				"<div class=\"col-md-12\"><h3 class=\"sectionTitle\" style=\"color: #666\">".
				"Server_info created successfully</h3></div></div>";
		
		unlink('init.php');
		
		echo "<br/><div class=\"row block\" style=\"background: #aaffbb;\">".
				"<div class=\"col-md-12\"><h3 class=\"sectionTitle\" style=\"color: #666\">".
				"init.php page was successfully deleted</h3></div></div>";
	}
?>


	</div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
