<!DOCTYPE html>
<html lang="en">

<?php include("head.php") ?>

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
					<h3>Edit Comments</h3>
				</div>

			</div>
			<!-- /page header -->


			<!-- Breadcrumbs line -->
			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="index.php">Home</a></li>
					<li class="active">Edit Comments</li>
				</ul>

				<div class="visible-xs breadcrumb-toggle">
					<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
				</div>

		
			</div>
			<!-- /breadcrumbs line -->         
		
        <h4>News Comments</h4>
        <div class="table-responsive" style ="width:90%;">

        <table id="mytable" class="table table-bordred table-striped">
            <thead>
                <th>News ID</th>
                <th>News Date</th>
                <th>Title</th>
                <th>Edit</th>
                <th>Delete</th>
            </thead>
			<tbody>
				<?php
				$sti = getAuthorsNews($_SESSION["userID"]);
				while ($news = oci_fetch_array($sti, OCI_ASSOC+OCI_RETURN_NULLS)) {?>
				<tr>
				<td><?php echo $news["ID"];?></td>
				<td><?php echo $news["NEWSDATE"]; ?></td>
				<td><?php echo $news["TITLE"]; ?></td>
				<td><p data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn btn-primary btn-xs" data-title="edit" data-toggle="modal" data-target="#<?php echo $news["ID"];?>" ><span class="glyphicon glyphicon-pencil"></span></button></p></td>
				<div class="modal fade" id="<?php echo $news["ID"];?>" role="dialog">
					<div class="modal-dialog">
    
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Modal Header</h4>
						</div>
						<div class="modal-body">
						<?php
							$stid = oci_parse($conn, 'SELECT USERNAME,CONTENT,COM_DATE FROM NEWS_COMMENT,USER_ where NEWSID = (:news_id) AND USERID=PERSONID ORDER BY COM_DATE desc');
								oci_bind_by_name($stid, ':news_id', $news["ID"]);
								oci_execute($stid);
								$i = 1;
								while ($newsPhoto = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
								
									echo '<strong class="pull-left primary-font">'.$newsPhoto["USERNAME"].'</strong>
									<small class="pull-right text-muted">
									<span class="glyphicon glyphicon-time"></span>'.$newsPhoto["COM_DATE"].'</small>
									</br>
									<li class="ui-state-default">'.$newsPhoto["CONTENT"].'</li>
									<button class="btn btn-danger btn-xs pull-right" id ="deletep">Delete</button>
									<br>	<hr>
									';
								
									
								}			
						?>
					
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</div>
      
			</div>
		</div>
				<td><p data-placement="top" data-toggle="tooltip" title="Delete"><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" ><span class="glyphicon glyphicon-trash"></span></button></p></td>  
				<?php } ?>
			</tbody>
        
		</table>
		</div>
		



	        <!-- Footer -->
	        <div class="footer clearfix">
		        <div class="pull-left">&copy; 2017. <a href="">B.News</a></div>
	        </div>
	        <!-- /footer -->


		</div>
		<!-- /page content -->


	</div>
	<!-- /page container -->
<script>
	$(document).ready(function() {
  $("#deletep").click(function(e) {
	  console.log("hello");
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: "/pages/test/",
      data: {
        id: $("#button_1").val(),
        access_token: $("#access_token").val()
      },
      success: function(result) {
        alert('ok');
      },
      error: function(result) {
        alert('error');
      }
    });
  });
</script>
</body>
</html>