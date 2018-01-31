<!DOCTYPE html>
<html lang="en">

<?php include("head.php") ?>
<?php
	if (isset($_POST["title"])) {
		$sti = oci_parse($conn, 'begin UPDATENEWS(:p1, :p3, :p4,:p5); end;');
		oci_bind_by_name($sti,':p1',$_POST["ID"]);
		oci_bind_by_name($sti,':p3',$_POST["title"]);
		oci_bind_by_name($sti,':p4',$_POST["content"]);
		oci_bind_by_name($sti,':p5',$_POST["visibility"]);
		oci_execute($sti);
	}
	
	$stid = oci_parse($conn, 'select * FROM news inner join author_news on ID=NEWSID AND AUTHORID=(:aid) ORDER BY NEWSDATE DESC ');
	oci_bind_by_name($stid,':aid', $_SESSION["userID"]);
	oci_execute($stid);
	
	if (isset($_POST["asc"])) {
		$stid = oci_parse($conn, 'select * FROM news inner join author_news on ID=NEWSID AND AUTHORID=(:aid) ORDER BY NEWSDATE ASC ');
		oci_bind_by_name($stid,':aid', $_SESSION["userID"]);
		oci_execute($stid);
	}
	
	else if (isset($_POST["new"])) {		
		$stid = oci_parse($conn, 'select * FROM news inner join author_news on ID=NEWSID AND AUTHORID=(:aid) and NEWSDATE = (SELECT max(NEWSDATE) from news inner join author_news on ID=NEWSID AND AUTHORID=(:aid))');
		oci_bind_by_name($stid,':aid', $_SESSION["userID"]);
		oci_execute($stid);
	}
	else if (isset($_POST["old"])) {
		$stid = oci_parse($conn, 'select * FROM news inner join author_news on ID=NEWSID AND AUTHORID=(:aid) and NEWSDATE = (SELECT min(NEWSDATE) from news inner join author_news on ID=NEWSID AND AUTHORID=(:aid))');
		oci_bind_by_name($stid,':aid', $_SESSION["userID"]);
		oci_execute($stid);
		
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
					<h3>Edit News</h3>
				</div>
			</div>
			<!-- /page header -->


			<!-- Breadcrumbs line -->
			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="index.php">Home</a></li>
					<li class="active">Edit News</li>
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
			while ($news = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
		?>
		<form action="" method="post">
			<div class="panel panel-default">
				<div class="panel-heading"><h6 class="panel-title"><i class="icon-bubble4"></i><?php echo 'DATE:' . $news["NEWSDATE"]; ?>	</h6></div>
					<div class="panel-body">
						<input type="text" class="form-control" name="ID" value = "<?php echo $news["ID"]; ?>" style="display:none">
						<div class="form-group">
							<label class="col-sm-2 control-label"> News Title: </label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="title" value = "<?php echo $news["TITLE"]; ?>"> 
								</div>
						</div>
						
						<br><br><br>
						
						<!-- news content -->
						<div class="form-group">
							<label class="col-sm-2 control-label">Content: </label>
							<div class="col-sm-10">
								<textarea rows="5" cols="5" class="form-control" name="content" placeholder ="<?php echo $news["DESCRIPTION"]; ?>"><?php echo $news["DESCRIPTION"]; ?></textarea>
							</div>
						</div>
						
						<div class="form-group" style="margin-top:12%;">
							<label class="col-sm-2 control-label">Visibility: </label>
								<label class="radio-inline radio-danger" style="margin-left:1.5%;">
									<input type="radio" name="visibility" value="1" class="styled" <?php if ($news['VISIBLE'] == '1') echo 'checked="checked"';  ?>>
									Yes
								</label>
								<label class="radio-inline radio-danger">
									<input type="radio" name="visibility" value="0" class="styled" <?php if ($news['VISIBLE'] == '0') echo 'checked="checked"';  ?>>
									No
								</label>
						</div>
									
						<div class="form-group" style=" margin-left:2%;">
							<label class="col-sm-2 control-label"></label>
							<input type="submit" value="SAVE" class="btn btn-primary">
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