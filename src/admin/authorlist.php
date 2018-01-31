<!DOCTYPE html>
<html lang="en">

<?php include("head.php") ?>
<?php
	if(isset($_POST["userid"])) {
		$sti = oci_parse($conn, 'begin DELETEPERSON(:p1); end;');
		oci_bind_by_name($sti,':p1',$_POST["userid"]);
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
					<h3>Author List</h3>
				</div>

			</div>
			<!-- /page header -->


			<!-- Breadcrumbs line -->
			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="index.php">Home</a></li>
					<li class="active">Author List</li>
				</ul>

				<div class="visible-xs breadcrumb-toggle">
					<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
				</div>	
			</div>
			<!-- /breadcrumbs line -->         
			

  <table id="mytable" class="table table-bordred table-striped">
                   
    <thead>
        <th>Name</th>
        <th>Surname</th>
		<th>Email</th>
        <th>Birthdate</th>
		<th>Signature</th>
        <th>Delete</th>
    </thead>
    <tbody>
    
    <tr>
		<?php
			$sti = getAuthors();
			while($user = oci_fetch_array($sti, OCI_ASSOC+OCI_RETURN_NULLS)) {
		?>
		<td><?php echo $user["NAME"] ?></td>
		<td><?php echo $user["SURNAME"] ?></td>
		<td><?php echo $user["EMAIL"] ?></td>
		<td><?php echo $user["BIRTHDATE"] ?></td>
		<td><?php echo $user["SIGNATURE"] ?></td>
		<td>
		<form action=""	 method="post">
		<input type="text" name="userid" value="<?php echo $user["ID"] ?>" style="display:none">
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