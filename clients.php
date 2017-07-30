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

    <script src="js/clients.js"></script>
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
							<li class="active">
								<a href="./clients.php">Clients</a>
							</li>
							<li>
								<a href="./hours.php">Hours</a>
							</li>
							<li>
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
					Create Client
				</h2>
				<form>
					<div class="col-md-3 col-sm-3 col-xs-6 form-group has-feedback">
						<input type="text" class="form-control has-feedback-left" id="name" placeholder="Name" />
						<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-6 form-group has-feedback">
						<input type="text" class="form-control has-feedback-left" id="user" placeholder="User Login" />
						<span class="fa fa-user-circle-o form-control-feedback left" aria-hidden="true"></span>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-6 form-group has-feedback">
						<input type="text" class="form-control has-feedback-left" id="email" placeholder="eMail" />
						<span class="fa fa-envelope-o form-control-feedback left" aria-hidden="true"></span>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-6 form-group has-feedback">
						<input type="text" class="form-control has-feedback-left" id="phone" placeholder="Phone" />
						<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
						<input type="button" class="form-control button" value="Add Client" onclick="createClient();" />
						<span class="fa fa-plus form-control-feedback left" aria-hidden="true" style="color:#fff;"></span>
					</div>
				</form>
			</div>
		</div>
		
		<br/><br/>
		
		<div class="row" id="clients">
			
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