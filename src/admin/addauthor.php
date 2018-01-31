<!DOCTYPE html>
<html lang="en">

<?php include("head.php") ?>
<?php
	if(!isset($_SESSION["adminID"])) {
		header("Location:login.php");
	}
	
	
	$default = "default.png";
	if(isset($_POST["firstname"])) {
		if($_POST["firstname"] =="" || $_POST["lastname"] =="" || $_POST["email"]=="" || $_POST["password"]=="" ||
			 $_POST["birthdate"] == "") {
			$error = "ERROR : All fields must be filled";
		}
		else {
			$myDateTime = DateTime::createFromFormat('Y-m-d', $_POST["birthdate"]);
			$_POST["birthdate"] = $myDateTime->format('d/M/Y');		
			$pass = MD5($_POST["password"]);
			
			// add person table 
			$stid = oci_parse($conn, 'begin INSERTPERSON(:p1, :p2 , :p3, :p4, 1, :p6, :p7); end;');
			
			oci_bind_by_name($stid, ':p1', $_POST["firstname"]);
			oci_bind_by_name($stid, ':p2', $_POST["lastname"]);
			oci_bind_by_name($stid, ':p3', $pass);
			oci_bind_by_name($stid, ':p4', $_POST["email"]);
			
			// PERMISSIONID
			oci_bind_by_name($stid, ':p6', $_POST["birthdate"]);
			oci_bind_by_name($stid, ':p7', $default);
			
			$r = oci_execute($stid,OCI_NO_AUTO_COMMIT);
			if (!$r) {    
				$e = oci_error($stid);
				trigger_error(htmlentities($e['message']), E_USER_ERROR);
			}
			
			// get id
			$stid = oci_parse($conn, 'SELECT * FROM PERSON WHERE EMAIL=(:mail)');
			oci_bind_by_name($stid, ':mail', $_POST["email"]);
			oci_execute($stid);
			while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
				$id = $row["ID"];
			}		
								
			// insert authortable 
			$signature = "new";
			$stid = oci_parse($conn, 'begin INSERTAUTHOR(:p3, :p1 ); end;');
			oci_bind_by_name($stid, ':p3', $id);
			oci_bind_by_name($stid, ':P1',$signature );
			$r = oci_execute($stid,OCI_NO_AUTO_COMMIT);

			if (!$r) {    
				$e = oci_error($stid);
				oci_rollback($conn);  // rollback changes to both tables
				trigger_error(htmlentities($e['message']), E_USER_ERROR);
			}
			$r = oci_commit($conn);	
			if ($r) {
				$ok ="1";
			}
			
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
					<h3>Add new Author</h3>
				</div>

			</div>
			<!-- /page header -->


			<!-- Breadcrumbs line -->
			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="index.php">Home</a></li>
					<li class="active">Add Author</li>
				</ul>

				<div class="visible-xs breadcrumb-toggle">
					<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
				</div>

		
			</div>
			<!-- /breadcrumbs line -->         
			<div class="container" style = "width:80%">
					<form action="" method="post" class="form-horizontal" role="form">
						<div class="form-group">
							<label for="firstName" class="col-sm-3 control-label">Name</label>
							<div class="col-sm-9">
								<input type="text" name="firstname" id="firstName" placeholder="Name" class="form-control" autofocus>
							</div>
						</div>
						<div class="form-group">
							<label for="firstName" class="col-sm-3 control-label">Surname</label>
							<div class="col-sm-9">
								<input type="text" name="lastname" id="lastname" placeholder="Lastname" class="form-control" autofocus>
							</div>
						</div>
						<div class="form-group">
							<label for="email" class="col-sm-3 control-label">Email</label>
							<div class="col-sm-9">
								<input type="text" name="email" id="email" placeholder="Email" class="form-control">
							</div>
						</div>
		
						<div class="form-group">
							<label for="password"  class="col-sm-3 control-label">Password</label>
							<div class="col-sm-9">
								<input type="password" name="password" id="password" placeholder="Password" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label for="birthDate" class="col-sm-3 control-label">Date of Birth</label>
							<div class="col-sm-9">
								<input type="date" name="birthdate" id="birthDate" class="form-control">
							</div>
						</div>
	
						
						<?php
							if(isset($error)) {
								echo '<div class="error" style="margin-left:27%;">'.$error .'</div>';
							}
							if(isset($ok)) {
								echo '<div class="alert alert-success" style="margin-left:27%;"> <strong>Success!</strong></div>';
							}
						
						?>
						
						<div class="form-group">
							<div class="col-sm-9 col-sm-offset-3">
								<button type="submit" class="btn btn-primary btn-block">ADD</button>
							</div>
						</div>
					</form> <!-- /form -->
				</div> <!-- ./container -->


		</div>
		<!-- /page content -->


	</div>
	<!-- /page container -->

</body>
</html>