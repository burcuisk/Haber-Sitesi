   <div id="header">
      <div class="clearer">&nbsp;</div>
      <div id="site-title">
        <h1><a href="index.php">B. <span> News</span></a></h1>
      </div>
      <div id="navigation">
        <div id="main-nav">
          <ul class="tabbed">		  
			<li class="current-tab" id="home_p"><a href="index.php">ALL</a></li>
			
			<?php
				$stid = oci_parse($conn, 'SELECT * FROM categories');
				oci_execute($stid);
				while($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
					echo '<li id="'.$row["ID"].'"><a href="category.php?id='.$row["ID"].'">'.$row["NAME"].'</a></li>';
				}
			?>
			
          </ul>
          <div class="clearer">&nbsp;</div>
        </div>
        <div id="sub-nav">
          <ul class="tabbed">
			<li id="auth"><a href="authors.php">AUTHORS</a></li>
			<?php
				
				if(isset($_SESSION['userType'])) {
					echo '<li><a href="logout.php">LOGOUT</a></li>';
				}
				else {
					echo '<li class="pull-right"><a href="login.php">LOGIN</a></li>';
					echo '<li class="pull-right"><a href="signup.php">SIGN UP</a></li>';
				}
			?>
			<?php 
				if(isset($_SESSION['userType'])) {
					echo '<div class="dropdown">
						  <button class="dropbtn">
							  <div style = "width: 20px; height: 3px;background-color: #334; margin: 4px 0;";></div>
							  <div style = "width: 20px; height: 3px;background-color: #334; margin: 4px 0;";></div>
							  <div style = "width: 20px; height: 3px;background-color: #334; margin: 4px 0;";></div>
						 </button>
						 
						  <div class="dropdown-content">
							<a href="profileedit.php">Edit Profile</a>
						  </div>
					</div>';
				}
			?>
			
        
          </ul>
          <div class="clearer">&nbsp;</div>
        </div>
      </div>
    </div>