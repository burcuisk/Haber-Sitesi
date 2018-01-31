<!DOCTYPE html>
<html lang="en">

<?php include("head.php") ?>
<?php
	if(isset($_POST["description"])) {
		if (!empty($_FILES["fileToUpload"]["name"])){
			$target_dir = "../img/emoji/";
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
				// yukle
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				
				} 
				else {
					$error = "Sorry, there was an error uploading your file.";
				}
				$name = basename($_FILES["fileToUpload"]["name"]);
			}
		}
		if(!isset($error)) {
			$insertem = oci_parse($conn, 'begin INSERTEMOJI_TYPE((:desc),(:url)); end;');
			oci_bind_by_name($insertem,':desc', $_POST["description"] );
			oci_bind_by_name($insertem,':url', $name);
			oci_execute($insertem);
		}
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
					<h3>Add Emoji</h3>
				</div>

			</div>
			<!-- /page header -->


			<!-- Breadcrumbs line -->
			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="index.php">Home</a></li>
					<li class="active">Add Emoji</li>
				</ul>

				<div class="visible-xs breadcrumb-toggle">
					<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
				</div>
		
			</div>
			<!-- /breadcrumbs line -->         

			<form method="post" action="" class="form-horizontal" role="form"  enctype="multipart/form-data">
			<?php
				if(isset($error)) {
					echo '<div class="alert alert-info alert-dismissable">
						<a class="panel-close close" data-dismiss="alert">×</a> 
						<i class="fa fa-coffee"></i>
						 <strong>'. $error .'</strong>
						</div>';
				}
			?>
				<div class="form-group">
					<label class="col-lg-3 control-label">Description</label>
					<div class="col-lg-8">
						<input class="form-control" type="text" name="description">
					</div>
				</div>
				
				  
				  <input type="file" class="form-control" name="fileToUpload" id="fileToUpload" style="width:20%; margin-left:26%;"><br><br>
		
				
				<div class="form-group">
            <label class="col-md-3 control-label"></label>
            <div class="col-md-8">
              <input type="submit" class="btn btn-primary" value="ADD">
              <span></span>
      
            </div>
          </div>
            </div>
			</form>
	   
	   
		</div>
		<!-- /page content -->


	</div>
	<!-- /page container -->

</body>
</html>