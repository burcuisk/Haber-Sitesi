<?php include_once ("head.php"); ?>

<?php 

	function getUsers () {
		global $conn;
		$sti = oci_parse($conn, 'SELECT * FROM userlist');
		oci_execute($sti);
		return $sti;
	}
	
	function getAuthors () {
		global $conn;
		$sti = oci_parse($conn, 'SELECT * FROM authorlist');
		oci_execute($sti);
		return $sti;		
	}
	
	function getCategories () {
		global $conn;
		$sti = oci_parse($conn, 'SELECT * FROM category');
		oci_execute($sti);
		return $sti;		
	}
	




?>




