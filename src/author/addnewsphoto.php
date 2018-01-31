<!DOCTYPE html>
<html lang="en">

<?php include("head.php") ?>

<!-- gallery css -->
<style>
@import url('http://fonts.googleapis.com/css?family=Open+Sans:300');


.gallery {
  width: 1060px;
  margin: 0 auto;
  padding: 5px;
  background: #fff;
  box-shadow: 0 1px 2px rgba(0,0,0,.3);
}

.gallery > div {
  position: relative;
  float: left;
  padding: 5px;
}

.gallery > div > img {
  display: block;
  width: 200px;
  transition: .1s transform;
  transform: translateZ(0); /* hack */
}

.gallery > div:hover {
  z-index: 1;
}

.gallery > div:hover > img {
  transform: scale(1.7,1.7);
  transition: .3s transform;
}

.cf:before, .cf:after {
  display: table;
  content: "";
  line-height: 0;
}

.cf:after {
  clear: both;
}

h1 {
  margin: 40px 0;
  font-size: 30px;
  font-weight: 300;
  text-align: center;
}
img {
  filter: gray; /* IE6-9 */
  -webkit-filter: grayscale(1); /* Google Chrome, Safari 6+ & Opera 15+ */
    -webkit-box-shadow: 0px 2px 6px 2px rgba(0,0,0,0.75);
    -moz-box-shadow: 0px 2px 6px 2px rgba(0,0,0,0.75);
    box-shadow: 0px 2px 6px 2px rgba(0,0,0,0.75);
    margin-bottom:20px;
}

img:hover {
  filter: none; /* IE6-9 */
  -webkit-filter: grayscale(0); /* Google Chrome, Safari 6+ & Opera 15+ */
</style>


<?php
	// photo upload
	if(isset($_POST["photo"])) {
		$target_dir = "../img/news_photo/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		 $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			$uploadOk = 1;
		}
		else {
			$uploadOk = 0;
		}
		if (file_exists($target_file)) {
			$error = "Sorry, file already exists.";
			$uploadOk = 0;
		}
		if ($_FILES["fileToUpload"]["size"] > 500000) {
			$error = "Sorry, your file is too large.";
			$uploadOk = 0;
		}
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				$error ="Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		}
		if ($uploadOk == 0) {
			$error = "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} 
		else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			
			} 
			else {
				$error = "Sorry, there was an error uploading your file.";
			}
		}
		
		if (!isset($error)) {
			$name = basename($_FILES["fileToUpload"]["name"]);
			// add database
			$addphoto = oci_parse($conn, 'begin INSERTNEWS_PHOTO(:url, :news_id , :a_id); end;');
			oci_bind_by_name($addphoto,':url', $name );
			oci_bind_by_name($addphoto,':news_id', $_POST["newsid"]);
			oci_bind_by_name($addphoto,':a_id', $_SESSION["userID"]);
			oci_execute($addphoto);
		}
	}
	
	
	// get news according to filter 
	$sti = oci_parse($conn, 'select * FROM news inner join author_news on ID=NEWSID AND AUTHORID=(:aid) ORDER BY NEWSDATE DESC ');
	oci_bind_by_name($sti,':aid', $_SESSION["userID"]);
	oci_execute($sti);
	
	if (isset($_POST["asc"])) {
		$sti = oci_parse($conn, 'select * FROM news inner join author_news on ID=NEWSID AND AUTHORID=(:aid) ORDER BY NEWSDATE ASC ');
		oci_bind_by_name($sti,':aid', $_SESSION["userID"]);
		oci_execute($sti);
	}
	
	else if (isset($_POST["new"])) {		
		$sti = oci_parse($conn, 'select * FROM news inner join author_news on ID=NEWSID AND AUTHORID=(:aid) and NEWSDATE = (SELECT max(NEWSDATE) from news inner join author_news on ID=NEWSID AND AUTHORID=(:aid))');
		oci_bind_by_name($sti,':aid', $_SESSION["userID"]);
		oci_execute($sti);
	}
	else if (isset($_POST["old"])) {
		$sti = oci_parse($conn, 'select * FROM news inner join author_news on ID=NEWSID AND AUTHORID=(:aid) and NEWSDATE = (SELECT min(NEWSDATE) from news inner join author_news on ID=NEWSID AND AUTHORID=(:aid))');
		oci_bind_by_name($sti,':aid', $_SESSION["userID"]);
		oci_execute($sti);
		
	}

?>
<body>
	<?php include("navbar.php"); ?>
	
	<!-- Page container -->
 	<div class="page-container">


		<?php include("sidebar.php"); ?>


		<!-- Page content -->
	 	<div class="page-content">

			<!-- Page header -->
			<div class="page-header">
				<div class="page-title">
					<h3>Add News Photo</h3>
				</div>
			</div>
			<!-- /page header -->


			<!-- Breadcrumbs line -->
			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="index.php">Home</a></li>
					<li class="active">Add News Photo</li>
				</ul>

				<div class="visible-xs breadcrumb-toggle">
					<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
				</div>		
			</div>
			<!-- /breadcrumbs line -->


		
		<div class="col-sm-20">
		<b>Filter:</b> <br><br>
			<form action="" method="post" class="col-sm-2" style="margin:0"><input type="text" style="display:none; width:0%; height:0%;" name="asc"><button class="btn btn-default filter-button" type="submit" >Ascending By Date</button></form>
			<form action="" method="post" class="col-sm-2" style="margin:0"><input type="text" style="display:none; width:0%; height:0%;" name="desc"><button class="btn btn-default filter-button"  type="submit">Descending By Date</button></form>
			<form action="" method="post" class="col-sm-1" style="margin:0"><input type="text" style="display:none; width:0%; height:0%;" name="new"><button class="btn btn-default filter-button"  type="submit" >Newest</button></form>
			<form action="" method="post" class="col-sm-1" style="margin:0"><input type="text" style="display:none; width:0%; height:0%;" name="old"><button class="btn btn-default filter-button"  type="submit" >Oldest</button></form>
		</div> 
		<br><br><br><br>
		
		<?php 
			while ($news = oci_fetch_array($sti, OCI_ASSOC+OCI_RETURN_NULLS)) {
		?>
		<form action="" method="post" enctype="multipart/form-data">
			<div class="panel panel-default">
				<div class="panel-heading"><h6 class="panel-title"><i class="icon-bubble4"></i><?php echo 'DATE:' . $news["NEWSDATE"]; ?>	</h6></div>
					<div class="panel-body">
						<label class="col-sm-2 control-label"> News Title: </label> 
							<?php echo $news["TITLE"]; ?>
						<br><br><br>
						
						<label class="col-sm-2 control-label"> Content: </label> 
							<?php echo $news["DESCRIPTION"]; ?>
						
						<br><br><br>
							<label class="col-sm-2 control-label"> Select image to upload: </label> 
							<input type ="text" name="newsid" value="<?php echo $news["ID"]; ?>" style ="display:none" >
							<input type="file" name="fileToUpload" id="fileToUpload">
			
						<br>
						
						<input type="submit" name="photo" value="SAVE" class="btn btn-primary"><br>
						
						<div class="gallery cf">
							<?php
								if (isset ($error)) {
									echo '<div class="alert alert-warning">
									<strong>Warning!</strong>'. $error .'
									</div>' ;
								}
								$stid = oci_parse($conn, 'select PHOTOURL FROM NEWS_PHOTO WHERE NEWSID = (:nid) ');
								oci_bind_by_name($stid,':nid', $news["ID"]);
								oci_execute($stid);
								
								while ($photo = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
									echo '<div>
										<img class="img-responsive" style="height:130px;" src="../img/news_photo/'.$photo["PHOTOURL"] .'" />
									</div>';
								}
							?>
						  
						</div>
						
					</div>
				</div>
		</form>
		
		<?php } ?>


	        <!-- Footer -->
	        <div class="footer clearfix">
		        <div class="pull-left">&copy; 2017. <a href="">B.News</a></div>
	        </div>
	        <!-- /footer -->


		</div>
		<!-- /page content -->


	</div>
	<!-- /page container -->
	
</body>
</html>