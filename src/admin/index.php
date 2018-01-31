<!DOCTYPE html>
<html lang="en">

<?php include("head.php") ?>
<?php
	if(!isset($_SESSION["adminID"])) {
		header("Location:login.php");
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
					<h3>Dashboard</h3>
				</div>

			</div>
			<!-- /page header -->


			<!-- Breadcrumbs line -->
			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="index.php">Home</a></li>
					<li class="active">Dashboard</li>
				</ul>

				<div class="visible-xs breadcrumb-toggle">
					<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
				</div>

		
			</div>
			<!-- /breadcrumbs line -->         
			<b>Statistics</b><br> <hr>

			
			<b>Processing History :</b><br> <hr>
			

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