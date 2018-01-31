<?php include_once ("../config.php"); ?>

<?php 

	function getTotalNumberOfNews ($authorId ) {
		global $conn;
		$sti = oci_parse($conn, 'SELECT COUNT(*) FROM AUTHOR_NEWS WHERE AUTHORID = (:id)');
		oci_bind_by_name($sti,':id', $authorId);
		oci_execute($sti);
		
		oci_fetch($sti);
		return oci_result($sti, 'COUNT(*)');
	}
	
	function getTotalNumberOfVotes ($authorId) {
		global $conn;
		$sti = oci_parse($conn, 'SELECT COUNT(*) FROM NEWS_EMOJI natural join AUTHOR_NEWS WHERE AUTHORID = (:id) ');
		oci_bind_by_name($sti,':id', $authorId);
		oci_execute($sti);
		
		oci_fetch($sti);
		return oci_result($sti, 'COUNT(*)');
		
	}
	
	function getTotalComment ($authorId) {
		global $conn;
		$sti = oci_parse($conn, 'SELECT COUNT(*) FROM NEWS_COMMENT natural join AUTHOR_NEWS WHERE AUTHORID = (:id) ');
		oci_bind_by_name($sti,':id', $authorId);
		oci_execute($sti);
		
		oci_fetch($sti);
		return oci_result($sti, 'COUNT(*)');
	}
	
	function getAuthorsNews ($authorId) {
		global $conn;
		$sti = oci_parse($conn, 'select * FROM news inner join author_news on ID=NEWSID AND AUTHORID=(:aid) ORDER BY NEWSDATE DESC ');
		oci_bind_by_name($sti,':aid',$authorId);
		oci_execute($sti);
		return $sti;
		
		
	}




?>




