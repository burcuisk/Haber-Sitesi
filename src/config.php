<?php
	error_reporting(E_ALL); ini_set('display_errors', '1');

	$db = "(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = dbs.cs.hacettepe.edu.tr)(PORT = 1521)))(CONNECT_DATA = (SID = dbs)))";
	$conn = oci_connect("b21328103", "21328103", $db);
	if (!$conn) {
		$e = oci_error();   // For oci_connect errors do not pass a handle
		trigger_error(htmlentities($e['message']), E_USER_ERROR);
	}
	
?>