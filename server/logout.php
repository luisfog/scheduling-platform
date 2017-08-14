<?php
	ini_set('display_errors', '0');
	session_start();
	session_destroy();
	header('Location: ../index.html' );
	exit;
?>
