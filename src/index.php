<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
	<?php include("head.php"); ?>
<body id="top">

<div id="site">
  <div class="center-wrapper">
		
	<?php include("header.php");?>

    <div class="main" id="main-two-columns">
		<div class="left" id="main-left">
	  
			<?php
				if(isset($_SESSION['userType'])) 
					$stid = oci_parse($conn, 'SELECT * FROM newsdatas');
				
				else 
					$stid = oci_parse($conn, 'SELECT * FROM newsdatas where VISIBLE=1');
				
				oci_execute($stid);
				$i = 1;
				while($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
					if($i == 1 ) {
						echo '<div class="post">
								<div class="post-title">
									<h2><a href="news.php?id='.$row["NEWSID"].'">'.$row["TITLE"].'</a></h2>
								</div>
								<div class="post-date">'.$row["NEWSDATE"].' by '.$row["NAME"].' '.$row["SURNAME"].'
								
								<div class="post-body">	<br>	
								<p>'.shorter($row["DESCRIPTION"]).'</p>
								<a href="news.php?id='.$row["NEWSID"].'" class="more">Read more &#187;</a> </div>
								</div>
								<div class="content-separator"></div>';
					}
					else {
						echo '<div class="post"> 
								  <h3><a href="news.php?id='.$row["NEWSID"].'">'.$row["TITLE"].'</a></h3>
								  <div class="post-date">'.$row["NEWSDATE"].' by '.$row["NAME"].' '.$row["SURNAME"].'</div>
								  <p>'.shorter($row["DESCRIPTION"]).'</p>
								  <a href="news.php?id='.$row["NEWSID"].'" class="more">Read more &#187;</a>
								  <div class="clearer">&nbsp;</div>
								</div>
								<div class="content-separator"></div>';
					}
					$i++;
							
				}
				
			?>
			</div>
	  
      </div>
		
		<?php include("sidebar.php"); ?>
    </div>

    <?php include("footer.php"); ?>
  </div>
</div>
</body>
</html>
