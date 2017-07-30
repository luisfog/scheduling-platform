<?php
	ini_set('display_errors', '0');
	session_start();
	if(!isset($_SESSION['user'])){
		header('Location: index.html' );
		return;
	}
?>

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

    <script src="js/schedules.js"></script>
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
						<li>
							<a href="./clients.php">Clients</a>
						</li>
						<li>
							<a href="./hours.php">Hours</a>
						</li>
						<li class="active">
							<a href="./schedules.php">Schedules</a>
						</li>
						<li>
							<a href="./server/logout.php"><span class="fa fa-sign-out"></span></a>
						</li>
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
				Results Filter
			</h2>
			<form>
				<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
					<select id="filterAvailable" class="form-control has-feedback-left select">
					  <option value="-1">All clients</option>
					</select>
					<span class="fa fa-filter form-control-feedback left" aria-hidden="true"></span>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
					<select id="filterWhen" class="form-control has-feedback-left select">
					  <option value="today">Today</option>
					  <option value="tomorrow">Tomorrow</option>
					  <option value="10days" selected>Next 10 days</option>
					  <option value="30days">Next 30 days</option>
					  <option value="last30days">Done in last 30 days</option>
					</select>
					<span class="fa fa-filter form-control-feedback left" aria-hidden="true"></span>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
					<input type="button" class="form-control button" value="Filter" onclick="getSchedules();" />
					<span class="fa fa-plus form-control-feedback left" aria-hidden="true" style="color:#fff;"></span>
				</div>
			</form>
		</div>
	</div>
	
	<br/><br/>
	
	<div class="row" id="schedules">
	</div>
	
	<div class="modal" id="modalClose" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" onclick="this.parentElement.parentElement.parentElement.parentElement.style.display = 'none';">&times;</button>
					<h4 id="modalCloseTitle" class="modal-title"></h4>
				</div>
				<div class="modal-body" id="modalCloseText" >
					<p></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" onclick="this.parentElement.parentElement.parentElement.parentElement.style.display = 'none';">Close</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal" id="modalYes" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" onclick="this.parentElement.parentElement.parentElement.parentElement.style.display = 'none';">&times;</button>
					<h4 id="modalYesTitle" class="modal-title"></h4>
				</div>
				<div class="modal-body">
					<p id="modalYesText"></p>
				</div>
				<div class="modal-footer">
					<button id="modalYesButton" type="button" class="btn btn-success">Yes</button>
					<button type="button" class="btn btn-default" onclick="this.parentElement.parentElement.parentElement.parentElement.style.display = 'none';">No</button>
				</div>
			</div>
		</div>
	</div>
</div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>