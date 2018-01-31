<!DOCTYPE html>
<html lang="en">

<?php include("head.php") ?>
<?php
	if(isset($_POST["name"])) {
		$sti = oci_parse($conn, 'begin INSERTCATEGORY(:p1); end;');
		oci_bind_by_name($sti,':p1',$_POST["name"]);
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
					<h3>Categories</h3>
				</div>

			</div>
			<!-- /page header -->


			<!-- Breadcrumbs line -->
			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="index.php">Home</a></li>
					<li class="active">Categories</li>
				</ul>

				<div class="visible-xs breadcrumb-toggle">
					<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
				</div>

		<form action="" method="post">
			<div class="panel panel-default">
				<div class="panel-heading"><h6 class="panel-title">New Category<i class="icon-bubble4"></i></h6></div>
					<div class="panel-body">
						<div class="form-group">
							<label class="col-sm-2 control-label">Name: </label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="name"> 
								</div>
						</div>
						
						<br><br><br>						
			
									
						<div class="form-group" style=" margin-left:2%;">
							<label class="col-sm-2 control-label"></label>
							<input type="submit" value="ADD" class="btn btn-primary">
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