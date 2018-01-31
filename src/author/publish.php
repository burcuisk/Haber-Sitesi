<!DOCTYPE html>
<html lang="en">

<?php include("head.php") ?>

<?php 
	// get managed categories for author
	$stid = oci_parse($conn, 'select NAME,ID FROM CATEGORY_MANAGE inner join CATEGORY on ID=CATEGORYID AND AUTHORID= (:aid)');
	oci_bind_by_name($stid ,':aid', $_SESSION['userID']);
	oci_execute($stid);
	
	if(isset($_POST["title"])) {
		if (empty($_POST["title"]) || empty($_POST["visibility"]) || empty($_POST["content"])) {
			$error = "No field can be left blank.";
		}
		else {
			$visibility = $_POST["visibility"];
			$title = $_POST["title"];
			$content = $_POST["content"];
			
			$sti = oci_parse($conn, 'begin INSERTNEWS(:p1, :p3, :p4); end;');
			oci_bind_by_name($sti, ':p1', $title);
			oci_bind_by_name($sti, ':p3', $content);
			oci_bind_by_name($sti, ':p4', $visibility);
			if ( !oci_execute($sti,OCI_DEFAULT) ) {
					oci_rollback($conn);
					exit(1);
			}
			
			$stia = oci_parse($conn, 'select ID from NEWS where TITLE = (:p1) AND DESCRIPTION = (:p2) AND VISIBLE=(:p3)');
			oci_bind_by_name($stia, ':p1', $title);
			oci_bind_by_name($stia, ':p2', $content);
			oci_bind_by_name($stia, ':p3', $visibility);
			if ( !oci_execute($stia,OCI_DEFAULT) ) {
					oci_rollback($conn);
			}
			$row = oci_fetch_array($stia, OCI_ASSOC+OCI_RETURN_NULLS);
			
			
			$getdate = oci_parse($conn, 'SELECT CURRENT_DATE from dual');
			oci_execute($getdate);
			$curDate = oci_fetch_array($getdate, OCI_ASSOC+OCI_RETURN_NULLS);
			
			$stiia = oci_parse($conn, 'begin INSERTAUTHORNEWS(:p1, :p2,:p3); end;');
			oci_bind_by_name($stiia, ':p1', $_SESSION['userID']);
			oci_bind_by_name($stiia, ':p2', $row["ID"]);
			oci_bind_by_name($stiia, ':p3',$curDate['CURRENT_DATE']  );
			$r = oci_execute($stiia,OCI_NO_AUTO_COMMIT);
				
			$sti3  =oci_parse($conn, 'begin INSERTNEWS_CATEGORY(:p1, :p2); end;');
			foreach($_POST['category'] as $category) {
				oci_bind_by_name($sti3,':p1', $row["ID"]);
				oci_bind_by_name($sti3,':p2', $category);
			}

			if ( !oci_execute($sti3,OCI_DEFAULT) ) {
				oci_rollback($conn);
				die;
			}
			
			oci_commit($conn);
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
					<h3>Publish News</h3>
				</div>

			</div>
			<!-- /page header -->


			<!-- Breadcrumbs line -->
			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="index.php">Home</a></li>
					<li class="active">Publish News</li>
				</ul>

				<div class="visible-xs breadcrumb-toggle">
					<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
				</div>		
		
			</div>
			<!-- /breadcrumbs line -->
			
			<?php 
			if (isset($error)) {
				echo '<div class="alert alert-warning">
						<strong>Error!</strong>'.$error .'
					</div>';

			}
			?>
			
			<!-- Basic inputs -->
			<form action="" method="post">
		        <div class="panel panel-default">
			        <div class="panel-heading"><h6 class="panel-title"><i class="icon-bubble4"></i> News Datas</h6></div>
						<div class="panel-body">
					
                    	<div class="alert alert-success fade in block-inner">
                    		<button type="button" class="close" data-dismiss="alert">×</button>
                    		You can only add news in categories where you are the manager.
                    	</div>

						<div class="form-group">
							<label class="col-sm-2 control-label"> News Title: </label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="title">
							</div>
						</div>
						<br><br><br>
						
						<!-- news content -->
						<div class="form-group">
							<label class="col-sm-2 control-label">Content: </label>
							<div class="col-sm-10">
								<textarea rows="5" cols="5" class="form-control" name="content"></textarea>
							</div>
						</div>
						
						<div class="form-group" style="margin-top:12%;">
							<label class="col-sm-2 control-label">Visibility: </label>
								<label class="radio-inline radio-danger" style="margin-left:1.5%;">
									<input type="radio" name="visibility" value="1" class="styled">
									Yes
								</label>
								<label class="radio-inline radio-danger">
									<input type="radio" name="visibility" value="0" class="styled" checked="checked">
									No
								</label>
				
						</div>
						
						<div class="form-group" >
							<label class="col-sm-2 control-label">Categories: </label>
							<div class="col-sm-10">
								<div class="block-inner">
								<?php 
									$i = 0;
									while ($managedcategories = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
										echo '<label class="checkbox-inline checkbox-danger">
												<input type="checkbox" class="styled" name="category[]" value='.$managedcategories["ID"].'>
											'.$managedcategories["NAME"].'
											</label>';
										$i++;
									}
									if ($i == 0) {
										echo 'You cannot publish news any category please contact to admin'; 
									}
								?>
									
									
									
								</div>

							</div>
						</div>

			
						<div class="form-group" style=" margin-left:2%;">
							<label class="col-sm-2 control-label"></label>
							<input type="submit" value="PUBLISH" class="btn btn-primary">
						</div>
			</form>
						
					</div>
					</div>
				</div>
				<!-- /basic inputs -->


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