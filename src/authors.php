<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
	<?php include("head.php"); ?>
<body id="top">

<?php
if(isset($_POST["category"])) {
	echo 'hi';
}	

?>
<style>
.profile-teaser-left {
    float: left; width: 20%; margin-right: 1%;
}
.profile-img img {
    width: 100%; height: auto;
}

.profile-teaser-main {
    float: left; width: 79%;
}

.info { display: inline-block; margin-right: 10px; color: #777; }
.info span { font-weight: bold; }
</style>

<div id="site">
	<div class="center-wrapper">
  
	<?php include("header.php");?>
	
	<link rel="stylesheet" type="text/css" href="css/authors.css" media="screen" />
	
		<div class="main" id="main-two-columns">
			<div class="left" id="main-left">
				<div class="row" style="margin-left:6%; margin-bottom:5%; ">
					<form action="" method="post" class="col-md-5" style="margin-right:-9%;" id="catform">					
						<label for="country" class="control-label">	
							Category Manager
						</label>	
						<select name="category" id="country" form="catform">
							<option value=""></option>
							<option value="all">ALL</option>
							<?php
								$stid = oci_parse($conn, 'SELECT * FROM categories');
								oci_execute($stid);
								while($categories = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
									echo '<option value="'.$categories["ID"].'">'.$categories["NAME"].'</option>';
								}
							
							?>
						</select>
						 <button type="submit" class="btn btn-primary">Filter</button>
							
					</form>
					<div class= "col-md-4" style="margin-top:3.7%;">
						<button type="button" class="btn btn-primary"><a href='authors.php?max=true' style="color:white">Have max numb of news</a></button>
					</div>
					<div class= "col-md-4 " style="margin-top:3.7%;">
						<button type="button" class="btn btn-primary"><a href='authors.php?min=true' style="color:white">Have min numb of news  </a></button>
					</div>
				</div>
				
				
				<div class="container">
					<div class="row">
						<div class="list-group" style="width:65%;">
							<?php
							if(isset($_GET["max"]) || isset($_GET["min"])) {
								if(isset($_GET["max"]))
									$stid = oci_parse($conn, 'select * from MAX_NUMB_NEWS_AUTH');
								else 
									$stid = oci_parse($conn, 'select * from MIN_NUMB_NEWS_AUTH');
								oci_execute($stid);
								while($author = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
									$sti = oci_parse($conn, 'SELECT * from category_manage,category where AUTHORID=(:id) and CATEGORYID = ID');
									oci_bind_by_name($sti, ':id', $author["ID"]);
									oci_execute($sti);
									echo '<div class="list-group-item clearfix" style=" margin-bottom:2%;">
											<div class="profile-teaser-left">
												<div class="profile-img"><img src="img/userpp/'.$author["PP"] .'" style="height:100px; width:120px;"/></div>
											</div>
											<div class="profile-teaser-main">
												<h4 class="profile-name">'.$author["NAME"] .' '.$author["SURNAME"] .'
												<div class="info" style="font-size:13px"><span class="">_</span>'.$author["SIGNATURE"] .'</div> </h4>
												<div class="profile-info">		
													<div class="info"><span class="">Birthdate: </span>'.$author["BIRTHDATE"] .'</div><br>													
													<div class="info"><span class="">Manage: </span>';
													while($cat = oci_fetch_array($sti, OCI_ASSOC+OCI_RETURN_NULLS)) {
														echo $cat["NAME"]. ' ';
													}
													echo '</div>														
												</div>
											</div>
										</div>';
							
								}
							}
							
							// list for category manage 
							else if(isset($_POST["category"]) && $_POST["category"] != 'all' && $_POST["category"] != '' ) {
							
								$stid = oci_parse($conn, 'SELECT * FROM category_manage cm,author a,person p where cm.AUTHORID = a.PERSONID and cm.AUTHORID = p.ID and cm.CATEGORYID = (:cid)');
								oci_bind_by_name($stid, ':cid', $_POST["category"]);
								oci_execute($stid);
								$i =1;
								while($author = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
									$sti = oci_parse($conn, 'SELECT * from category_manage,category where AUTHORID=(:id) and CATEGORYID = ID');
									oci_bind_by_name($sti, ':id', $author["ID"]);
									oci_execute($sti);
									echo '<div class="list-group-item clearfix" style=" margin-bottom:2%;">
											<div class="profile-teaser-left">
												<div class="profile-img"><img src="img/userpp/'.$author["PP"] .'" style="height:100px; width:120px;"/></div>
											</div>
											<div class="profile-teaser-main">
												<h4 class="profile-name">'.$author["NAME"] .' '.$author["SURNAME"] .'
												<div class="info" style="font-size:13px"><span class="">_</span>'.$author["SIGNATURE"] .'</div> </h4>
												<div class="profile-info">		
													<div class="info"><span class="">Birthdate: </span>'.$author["BIRTHDATE"] .'</div><br>													
													<div class="info"><span class="">Manage: </span>';
													while($cat = oci_fetch_array($sti, OCI_ASSOC+OCI_RETURN_NULLS)) {
														echo $cat["NAME"]. ' ';
													}
													echo '</div>														
												</div>
											</div>
										</div>';
									$i++;
								}
								if ($i == 1) 
									echo '<div class="alert alert-info">
											<strong>This category has no manager yet!</strong> 
										  </div>';
		
							}
							
							// list all 
							else {
								$stid = oci_parse($conn, 'SELECT * FROM authorlist');
								oci_execute($stid);
									while($author = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
											$sti = oci_parse($conn, 'SELECT * from category_manage,category where AUTHORID=(:id) and CATEGORYID = ID');
											oci_bind_by_name($sti, ':id', $author["ID"]);
											oci_execute($sti);
											echo '<div class="list-group-item clearfix" style=" margin-bottom:2%;">
													<div class="profile-teaser-left">
														<div class="profile-img"><img src="img/userpp/'.$author["PP"] .'" style="height:100px; width:120px;"/></div>
													</div>
													<div class="profile-teaser-main">
														<h4 class="profile-name">'.$author["NAME"] .' '.$author["SURNAME"] .'
														<div class="info" style="font-size:13px"><span class="">_</span>'.$author["SIGNATURE"] .'</div> </h4>
														<div class="profile-info">		
															<div class="info"><span class="">Birthdate: </span>'.$author["BIRTHDATE"] .'</div><br>													
															<div class="info"><span class="">Manage: </span>';
															while($cat = oci_fetch_array($sti, OCI_ASSOC+OCI_RETURN_NULLS)) {
																echo $cat["NAME"]. ' ';
															}
															echo '</div>														
														</div>
													</div>
												</div>';
									}
							}
							?>
							
						
						</div>
					</div>
				</div>
			</div>		  
		</div>		
		
		<?php include("sidebar.php"); ?>
    </div>

    <?php include("footer.php"); ?>
	
	<script>
		var d = document.getElementById("auth");
		d.className += " current-tab";
	</script>

 </div>

</body>
</html>