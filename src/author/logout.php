<?php
	include ("config.php");
	include ("head.php");
	session_destroy();
	header("Location: index.php");
?>