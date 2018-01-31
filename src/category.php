<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
	<?php include("head.php"); ?>

<body id="top">

<div id="site">
  <div class="center-wrapper">
  
	<?php include("header.php"); ?>
	
    <div class="main" id="main-two-columns">
      <div class="left" id="main-left">
       <?php
			if(isset($_GET["id"])) {
				if(isset($_SESSION['userType'])) 
					$stid = oci_parse($conn, 'SELECT * FROM NEWS_CATEGORY nc,NEWS N,AUTHOR_NEWS an,AUTHOR a,PERSON p where a.PERSONID = an.AUTHORID and a.PERSONID = p.ID and nc.NEWSID = n.ID and nc.NEWSID = an.NEWSID and nc.CATEGORYID = (:cat_id)');
				else
					$stid = oci_parse($conn, 'SELECT * FROM NEWS_CATEGORY nc,NEWS N,AUTHOR_NEWS an,AUTHOR a,PERSON p where a.PERSONID = an.AUTHORID and a.PERSONID = p.ID and nc.NEWSID = n.ID and nc.NEWSID = an.NEWSID and nc.CATEGORYID = (:cat_id) and n.VISIBLE = 1');
				oci_bind_by_name($stid, ':cat_id', $_GET["id"]);
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

				if ($i == 1) {
					echo '<div class="alert alert-info" style="margin-right:0">
						  <strong>There is no news in this category.!</strong> 
						</div>
';
				}
			}						
			else 
				header("Location: index.php");
		?>
		</div>
	</div>
	
	<?php include("sidebar.php"); ?>
    
	</div>

    <?php include("footer.php"); ?>
  </div>
	
	<script>
		var d = document.getElementById("<?php echo $_GET["id"] ?>");
		d.className += " current-tab";
		var x = document.getElementById("home_p");
		x.className ="";
	</script>
</div>
</body>
</html>
