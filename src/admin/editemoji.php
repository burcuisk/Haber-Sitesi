<!DOCTYPE html>
<html lang="en">

<?php include("head.php") ?>
<?php
		if(isset($_POST["emid"])) {
		$sti = oci_parse($conn, 'begin DELETEEMOJI_TYPE(:p1); end;');
		oci_bind_by_name($sti,':p1',$_POST["emid"]);
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
					<h3>Edit Emoji</h3>
				</div>

			</div>
			<!-- /page header -->


			<!-- Breadcrumbs line -->
			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="index.php">Home</a></li>
					<li class="active">Edit Emoji</li>
				</ul>

				<div class="visible-xs breadcrumb-toggle">
					<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
				</div>

		
			</div>
			<!-- /breadcrumbs line -->         

			 <table id="mytable" class="table table-bordred table-striped">
                   
    <thead>
        <th>#</th>
		<th>Description</th>
        <th>Delete</th>
    </thead>
    <tbody>
    
    <tr>
		<?php
			$sti = oci_parse($conn, 'SELECT * FROM EMOJI_TYPE');
			oci_execute($sti);
			while($emoji = oci_fetch_array($sti, OCI_ASSOC+OCI_RETURN_NULLS)) {
		?>
		<td><img src = "../img/emoji/<?php echo $emoji["PHOTOURL"] ?>" style="width:50px; height:50px;"></td>
		<td><?php echo $emoji["DESCRIPTION"] ?></td>

		<td>
		<form action="" method="post">
		<input type="text" name="emid" value="<?php echo $emoji["ID"] ?>" style="display:none">
		<button type="submit" class="btn btn-danger btn-xs" data-title="Delete" ><span class="glyphicon glyphicon-trash"></span></button>
		</form></td>
		</tr>
			<?php } ?>

    </tbody>
        
</table>
			

		</div>
		<!-- /page content -->


	</div>
	<!-- /page container -->

</body>
</html>