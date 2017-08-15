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

	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="js/hours.js"></script>
  
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
							<li class="active">
								<a href="./hours.php">Hours</a>
							</li>
							<li>
								<a href="./schedules.php">Schedules</a>
							</li>
							<li>
								<a title="Logout" href="./server/logout.php"><span class="fa fa-sign-out"></span></a>
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
					Create Available Hour
				</h2>
				<form>
					<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
						<select id="selectRepeat" class="form-control has-feedback-left select" onchange="changeRepeat();">
						  <option value="forever">Repeat forever</option>
						  <option value="once">Only once</option>
						</select>
						<span class="fa fa-retweet form-control-feedback left" aria-hidden="true"></span>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
						<input type="text" id="day" class="form-control has-feedback-left" disabled>
						<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
						<select id="days" class="form-control has-feedback-left select">
						  <option value="mondays">Mondays</option>
						  <option value="tuesdays">Tuesdays</option>
						  <option value="wednesdays">Wednesdays</option>
						  <option value="thursdays">Thursdays</option>
						  <option value="fridays">Fridays</option>
						  <option value="saturdays">Saturdays</option>
						  <option value="sundays">Sundays</option>
						</select>
						<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
						<select id="hour" class="form-control has-feedback-left select">
						  <option value="0">00h00min</option>
						  <option value="1">01h00min</option>
						  <option value="2">02h00min</option>
						  <option value="3">03h00min</option>
						  <option value="4">04h00min</option>
						  <option value="5">05h00min</option>
						  <option value="6">06h00min</option>
						  <option value="7">07h00min</option>
						  <option value="8">08h00min</option>
						  <option value="9">09h00min</option>
						  <option value="10">10h00min</option>
						  <option value="11">11h00min</option>
						  <option value="12">12h00min</option>
						  <option value="13">13h00min</option>
						  <option value="14">14h00min</option>
						  <option value="15">15h00min</option>
						  <option value="16">16h00min</option>
						  <option value="17">17h00min</option>
						  <option value="18">18h00min</option>
						  <option value="19">19h00min</option>
						  <option value="20">20h00min</option>
						  <option value="21">21h00min</option>
						  <option value="22">22h00min</option>
						  <option value="23">23h00min</option>
						</select>
						<span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
						<select id="available" class="form-control has-feedback-left select">
						  <option value="-1">Available for all</option>
						</select>
						<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
						<input type="button" class="form-control button" value="Add Hour" onclick="addHour();" />
						<span class="fa fa-plus form-control-feedback left" aria-hidden="true" style="color:#fff;"></span>
					</div>
				</form>
			</div>
		</div>
		
		<br/><br/>
		
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
						<select id="filterType" class="form-control has-feedback-left select">
						  <option value="all">All types</option>
						  <option value="forever">Repeat forever</option>
						  <option value="once">Only once</option>
						</select>
						<span class="fa fa-filter form-control-feedback left" aria-hidden="true"></span>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
						<input type="button" class="form-control button" value="Filter" onclick="getHours();" />
						<span class="fa fa-plus form-control-feedback left" aria-hidden="true" style="color:#fff;"></span>
					</div>
				</form>
			</div>
		</div>
		
		<br/><br/>
		
		<div class="row" id="hours">
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

    <script src="js/bootstrap.min.js"></script>
  </body>
</html>