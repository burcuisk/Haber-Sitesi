 <?php include("head.php") ?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>b. News</title>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

  <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
  <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

      <link rel="stylesheet" href="css/login.css">  
</head>


<?php
if (isset($_POST['email']) && isset($_POST['password'])) {
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	$stid = oci_parse($conn, 'SELECT * FROM admin WHERE email=(:mail) and password=(:pass)');
	oci_bind_by_name($stid, ':mail', $email);
	oci_bind_by_name($stid, ':pass', $password);
	oci_execute($stid);
	$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
	
	if ($row["ID"] == "") 
		$error = "Invalid username or password!";
	else {
		$stid = oci_parse($conn, 'SELECT count(*) C FROM author WHERE PERSONID=(:id)');
		oci_bind_by_name($stid, ':id', $row["ID"]);
		oci_execute($stid);
		$author = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
		
		$_SESSION['adminID'] = $row["ID"];
		header("Location:index.php");
	}
}

?>

<body>
  
<!-- Form Mixin-->
<!-- Input Mixin-->
<!-- Button Mixin-->
<!-- Pen Title-->
<div class="pen-title">
  <h1>Sign In / B. - News Admin Panel</h1>
</div>
<!-- Form Module-->
<div class="module form-module">
  <div class="toggle"><i class="fa fa-times fa-pencil"></i>
   
  </div>
  <div class="form">

    <h2>Login to your account</h2>
    <form action="login.php" method="POST" id="login">	
      <input type="text" name ="email" placeholder="Email"/>
      <input type="password" name="password" placeholder="Password"/>
	  <?php 
		if (isset($error)) 
			echo $error."<br>";
	  ?>
      <input type="submit" form="login" value="Login"/>
    </form>
  </div>

 
</div>
	<!-- <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script> -->
	

</body>
</html>
