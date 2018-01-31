
<div id="footer">
      <div class="left">&copy; 2017 B.News<span class="text-separator">&rarr;</span> 
	  <span class="text-separator">|</span><a href="index.php">Home</a> <span class="text-separator">|</span>
	  
		<?php
			$stid = oci_parse($conn, 'SELECT * FROM categories');
			oci_execute($stid);
			while($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
				echo '</span> <a href="#">'.$row["NAME"].'</a> <span class="text-separator">| </span> ';
			}
		?>
		
	  </div>      
      <div class="clearer">&nbsp;</div>
</div>