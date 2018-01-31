<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
	<?php 
		include("head.php"); 
		
		$default = "default.png";
		if(isset($_POST["username"])) {
			if($_POST["firstname"] =="" || $_POST["lastname"] =="" || $_POST["username"] =="" || $_POST["email"]=="" || $_POST["password"]=="" 
				|| $_POST["gender"]=="" || $_POST["birthdate"] == "") {
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
									
				// insert usertable 
				$stid = oci_parse($conn, 'begin INSERTUSER(:p3, :p1 , :p2); end;');
				oci_bind_by_name($stid, ':p1', $_POST["username"]);
				oci_bind_by_name($stid, ':p2', $_POST["gender"]);
				oci_bind_by_name($stid, ':p3', $id);
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
	<style>
	body {
    background-color: #eee;
	}

	*[role="form"] {
		max-width: 600px;
		padding: 15px;
		background-color: #fff;
		border-radius: 0.3em;
		margin-left:16%;
		margin-bottom:3%;
	}

	*[role="form"] h2 {
		margin-left: 5em;
		margin-bottom: 1em;
	}


	</style>
	<body id="top">
		<div id="site">
			<div class="center-wrapper">
  
				<?php include("header.php");?> 
				
				<div class="container">
					<form action="" method="post" class="form-horizontal" role="form">
						<h2>Register</h2>
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
							<label for="password" class="col-sm-3 control-label">Username</label>
							<div class="col-sm-9">
								<input type="text" name="username" id="username" placeholder="Username" class="form-control">
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
						
						<div class="form-group">
							<label class="control-label col-sm-3">Gender</label>
							<div class="col-sm-6">
								<div class="row">
									<div class="radio col-sm-4">
										<label><input type="radio" name="gender" value="m">Male</label>
									</div>
									<div class="radio col-sm-4">
										<label><input type="radio" name="gender" value="f">Female</label>
									</div>
							   </div>
							</div>
						</div> <!-- /.form-group -->
						
						<?php
							if(isset($error)) {
								echo '<div class="error" style="margin-left:27%;">'.$error .'</div>';
							}
							if(isset($ok)) {
								echo '<div class="alert alert-success" style="margin-left:27%;"> <strong>Success!</strong>Kayıt Tamamlandı.</div>';
							}
						
						?>
						
						<div class="form-group">
							<div class="col-sm-9 col-sm-offset-3">
								<button type="submit" class="btn btn-primary btn-block">Register</button>
							</div>
						</div>
					</form> <!-- /form -->
				</div> <!-- ./container -->

		<?php include("footer.php"); ?>
		</div>
		
	</div>
</body>
</html>