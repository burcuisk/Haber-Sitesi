<!DOCTYPE html>
<html lang="en">

<?php include("head.php") ?>

<body>
	<?php include("navbar.php"); ?>
	<?php 
	$stid = oci_parse($conn, 'SELECT P.PP,P.NAME,P.SURNAME,P.PASSWORD,P.EMAIL,U.SIGNATURE FROM AUTHOR U, person p where U.PERSONID=(:u_id) and p.ID = (:u_id)');
	oci_bind_by_name($stid, ':u_id', $_SESSION['userID']);
	oci_execute($stid);
	$user = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
		
	if(isset($_POST["name"])) {
		if (empty($_POST["name"]) || empty($_POST["surname"]) || empty($_POST["signature"]) || empty($_POST["pass"]) ) {
			$error =  "No fields can be left blank.";
		}
		else {
			if (!empty($_FILES["fileToUpload"]["name"])){
				$target_dir = "../img/userpp/";
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
			else {
				$name = $user["PP"];
			}
			if (!isset($error)) {
			
				// add database
				$pass = md5($_POST["pass"]);
				$updatepers = oci_parse($conn, 'begin UPDATEPERSON(:id,:name , :surname,:pass,:pp); end;');
				oci_bind_by_name($updatepers,':id', $_SESSION["userID"] );
				oci_bind_by_name($updatepers,':name', $_POST["name"]);
				oci_bind_by_name($updatepers,':surname', $_POST["surname"]);
				oci_bind_by_name($updatepers,':pass', $pass);
				oci_bind_by_name($updatepers,':pp', $name);
				
				if ( !oci_execute($updatepers,OCI_DEFAULT) ) 
					oci_rollback($conn);
				
				$updateauthor = oci_parse($conn, 'begin UPDATEAUTHOR((:id),(:p2)); end;');
				oci_bind_by_name($updateauthor,':id', $_SESSION["userID"] );
				oci_bind_by_name($updateauthor,':p2', $_POST["signature"]);

				
				if ( !oci_execute($updateauthor,OCI_DEFAULT) ) 
					oci_rollback($conn);
				
				oci_commit($conn);
			}
			$stid = oci_parse($conn, 'SELECT P.PP,P.NAME,P.SURNAME,P.PASSWORD,P.EMAIL,U.SIGNATURE FROM AUTHOR U, person p where U.PERSONID=(:u_id) and p.ID = (:u_id)');
			oci_bind_by_name($stid, ':u_id', $_SESSION['userID']);
			oci_execute($stid);
			$user = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);

		}
		
		
	}
	?>

	<!-- Page container -->
 	<div class="page-container">


		<?php include("sidebar.php"); ?>


		<!-- Page content -->
	 	<div class="page-content">

			<!-- Page header -->
			<div class="page-header">
				<div class="page-title">
					<h3>Edit Profile</h3>
				</div>

			</div>
			<!-- /page header -->


			<!-- Breadcrumbs line -->
			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="index.php">Home</a></li>
					<li class="active">Edit Profile</li>
				</ul>

				<div class="visible-xs breadcrumb-toggle">
					<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
				</div>		
			</div>
			<!-- /breadcrumbs line -->         
			
			
			<form method="post" action="" class="form-horizontal" role="form"  enctype="multipart/form-data">
	<div class="row">
      <!-- left column -->
      <div class="col-md-3">
	  
        <div class="text-center">
          <img src="../img/userpp/<?php echo $user["PP"]; ?>" class="avatar img-circle" alt="profile" style ="width:100px; height:100px">
          <h6>Upload a different photo...</h6>
          
          <input type="file" class="form-control" name="fileToUpload" id="fileToUpload">
        </div>
      </div>
	 
      
      <!-- edit form column -->
      <div class="col-md-9 personal-info">
	  <?php
			if(isset($error)) {
				echo '<div class="alert alert-info alert-dismissable">
					<a class="panel-close close" data-dismiss="alert">×</a> 
					<i class="fa fa-coffee"></i>
					 <strong>'. $error .'</strong>
					</div>';
			}
	  ?>
	  
        <h3>Personal info</h3>
        
        
          <div class="form-group">
            <label class="col-lg-3 control-label">First name:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" name="name" value="<?php echo $user["NAME"]; ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Last name:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" name="surname" value="<?php echo $user["SURNAME"]; ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Signature:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" name="signature" value="<?php echo $user["SIGNATURE"]; ?>">
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label">Password:</label>
            <div class="col-md-8">
              <input class="form-control" type="text" name="pass" value="" placeholder="********">
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label"></label>
            <div class="col-md-8">
              <input type="submit" class="btn btn-primary" value="Save Changes">
              <span></span>
      
            </div>
          </div>
        </form>
			



		</div>
		<!-- /page content -->


	</div>
	<!-- /page container -->

</body>
</html>