<!-- Sidebar -->
		<div class="sidebar">
			<div class="sidebar-content">

				<!-- Main navigation -->
				<ul class="navigation">
					<li class="active"><a href="index.php "><span>Dashboard</span> <i class="icon-screen2"></i></a></li>
					<li>
						<a href="#"><span>Users</span> <i class="icon-paragraph-justify2"></i></a>
						<ul>
							<li><a href="userlist.php">User List</a></li>
							
							<li>
						<a href="#"><span>Author</span></a>
						<ul>
							<li><a href="authorlist.php">Author List</a></li>
							<li><a href="addauthor.php">Add New Author</a></li>
						</ul>
					</li>
						</ul>
					</li>
					<li>
						<a href="#"><span>Voting System</span> <i class="icon-grid"></i></a>
						<ul>
							<li><a href="editemoji.php">Edit Emojies</a></li>
							<li><a href="addemoji.php">Add New Emoji</a></li>
						</ul>
					</li>
					
					<li>
						<a href="#"><span>Categories</span> <i class="icon-paragraph-justify2"></i></a>
						<ul>
							<li><a href="category.php">Category List</a></li>
							<li><a href="addcategory.php">Add new Category</a></li>
							<li>
								<a href=""><span>Category Managers</span></a>
								<ul>
									<li><a href="category.php">List</a></li>
									<li>
									<a href=""><span>Edit</span></a>
									<?php
										$sti = oci_parse($conn, 'SELECT * FROM category');
										oci_execute($sti);
										while($cat = oci_fetch_array($sti, OCI_ASSOC+OCI_RETURN_NULLS)) {?>
										<ul>
											<li><a href=""><?php echo $cat["NAME"]; ?></a></li>
										</ul>
										<?php } ?>
									</li>
								</ul>
							</li>
						</ul>
					</li>
							
				</ul>
				<!-- /main navigation -->
				
			</div>
		</div>
		<!-- /sidebar -->