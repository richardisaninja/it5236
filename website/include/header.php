<?php

	// Assume the user is not logged in and not an admin
	$isadmin = FALSE;
	$loggedin = FALSE;

	// If we have a session ID cookie, we might have a session
	if (isset($_COOKIE['sessionid'])) {

		$user = $app->getSessionUser($errors);
		$loggedinuserid = $user["userid"];

		// Check to see if the user really is logged in and really is an admin
		if ($loggedinuserid != NULL) {
			$loggedin = TRUE;
			$isadmin = $app->isAdmin($errors, $loggedinuserid);
		}

	} else {

		$loggedinuserid = NULL;

	}


?>

	<div class="nav">
	  <div id="myNav" class="overlay">
 	 <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  	  <div class="overlay-content">
				<a href="#" id="submitPic">Submit a picture</a>
		&nbsp;&nbsp;
		<?php if (!$loggedin) { ?>
			<a href="login.php">Login</a>
			&nbsp;&nbsp;
			<a href="register.php">Register</a>
			&nbsp;&nbsp;
		<?php } ?>
		<?php if ($loggedin) {
			 ?>
			<a href="list.php">List</a>
			&nbsp;&nbsp;
			<a href="editprofile.php">Profile</a>
			&nbsp;&nbsp;
			<?php if ($isadmin) { ?>
				<a href="admin.php">Admin</a>
				&nbsp;&nbsp;
			<?php } ?>
			<a href="fileviewer.php?file=include/help.txt">Help</a>
			&nbsp;&nbsp;
			<a href="logout.php">Logout</a>
			&nbsp;&nbsp;

		<?php } ?>
	</div>
	</div>
	<span id="open-btn" style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>	</div>
	<script>
		function openNav() {
 		 document.getElementById("myNav").style.width = "100%";
		}

		function closeNav() {
 		 document.getElementById("myNav").style.width = "0%";
		}

		if(location.href == "http://34.239.165.227/it5236/website/index.php"){
			var white = document.getElementById("open-btn");
			var submit = document.getElementById("submitPic");
			white.style.color = "white";
			submit.style.display = "none";
		}

		


	</script>
