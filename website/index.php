<?php

// Import the application classes
require_once('include/classes.php');

// Create an instance of the Application class
$app = new Application();
$app->setup();

// Declare an empty array of error messages
$errors = array();

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Richard Murray's List</title>
	<meta name="description" content="Russell Thackston's personal website for IT 5236">
	<meta name="author" content="Russell Thackston">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/otherPages.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
	.overlay-content a {
		color: white;
		margin-right: 40px;
	}
	body{
		overflow-x: hidden;
		overflow-y: hidden;
	}
	.slideDown{
		transition: all .5s ease-in;
	}

	</style>
</head>
<body>
	<?php include 'include/header.php'; ?>
		<div class="background">
			<div class="circle">&#8250;</div>
				<div class="text">
					<div class="col-3">
						Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam
					</div>
				</div>
		</div>
	<?php include 'include/footer.php'; ?>
	<script src="js/site.js"></script>
	<script>


	var backgrounds = new Array(
	'url(https://images.unsplash.com/photo-1541060347332-57ad1362e09e?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=a43cd9bfdfc2a8211f23912f3edc2c3a&auto=format&fit=crop&w=1650&q=80)',
	'url(https://images.unsplash.com/photo-1541000020894-321f175f5a69?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=484d171f806ee8e5b347eb6e8af89207&auto=format&fit=crop&w=1650&q=80)',
	 'url(https://images.unsplash.com/photo-1540952407186-5aa22d90fcc6?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=7115e8e133b100148d48d2a97a891e04&auto=format&fit=crop&w=1189&q=80)'
	);
		var current = 0;

	$(function() {
	var body = $('.background');

	function nextBackground(n) {
	body.css(
	'background',
	backgrounds[current = ++current % backgrounds.length]
	);
	body.css(
		"background-position", "center"
	);
	body.addClass("slideDown");

	setTimeout(nextBackground, 5000);
	}
	setTimeout(nextBackground, 5000);
	body.css('background', backgrounds[0]);
	});

	</script>
</body>
</html>
