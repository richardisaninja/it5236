<?php

// Import the application classes
require_once('include/classes.php');

// Create an instance of the Application class
$app = new Application();
$app->setup();

// Declare an empty array of error messages
$errors = array();

// Check for logged in user since this page is protected
$app->protectPage($errors);

$name = "";

// Attempt to obtain the list of things
$things = $app->getThings($errors);



// Check for url flag indicating that there was a "no thing" error.
if (isset($_GET["error"]) && $_GET["error"] == "nothing") {
	$errors[] = "Things not found.";
}

// Check for url flag indicating that a new thing was created.
if (isset($_GET["newthing"]) && $_GET["newthing"] == "success") {
	$message = "Thing successfully created.";
}



// If someone is attempting to create a new thing, the process the request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Pull the title and thing text from the <form> POST
	$name = $_POST['name'];
	$attachment = $_FILES['attachment'];


	// Attempt to create the new thing and capture the result flag
	$result = $app->addThing($name, $attachment, $errors);
  //attempt to delete the thing from database and capture the result flag
	$delete = $app->deleteThing($name, $attachment, $errors);

	// Check to see if the new thing attempt succeeded
	if ($result == TRUE) {

		// Redirect the user to the login page on success
	    header("Location: list.php?newthing=success");
		exit();

	}
	// Check to see if the new thing attempt succeeded
	if ($delete == TRUE) {

		// Redirect the user to the login page on success
			header("Location: list.php?deletething=success");
		exit();

	}

}


?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>russellthackston.me</title>
	<meta name="description" content="Richard Murray's personal website for IT 5233">
	<meta name="author" content="Russell Thackston">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/otherPages.css">
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<!--1. Display Errors if any exists
	2. If no errors display things -->
<body>
	<?php include('include/header.php'); ?>
	<?php include('include/messages.php'); ?>
<!--
	<div class="search">
		<form action="list.php" method="post">
			<label for="search">Filter:</label>
			<input type="text" id="search" name="search"/>
			<input type="submit" value="Apply" />
		</form>
	</div>
-->
<!--Code that might be needed-->

<br>
<br>
<div class="body">
<div class="col-6">
<?php
$input = $things;
$len = count($input);
$firsthalf = array_slice($input, 0, $len / 2);
$secondhalf = array_slice($input, $len / 2);
	//https://stackoverflow.com/questions/5393028/how-can-i-take-an-array-divide-it-by-two-and-create-two-lists
	foreach ($firsthalf as $thing){
	?>
<div class="container-ov"><a href="thing.php?thingid=<?php echo $thing['thingid']; ?>"><img class="myImg" src="attachments/<?php echo $thing['thingattachmentid'] . '-' . $thing['filename']; ?>"><div class="overlay-ov"><div class="text1"><span class="author"><?php echo $thing['filename']; ?></div>
</div></a></div>

<?php }
?>
</div>

<div class="col-6">
<?php
$input = $things;
$len = count($input);
$firsthalf = array_slice($input, 0, $len / 2);
$secondhalf = array_slice($input, $len / 2);
	//https://stackoverflow.com/questions/5393028/how-can-i-take-an-array-divide-it-by-two-and-create-two-lists
	foreach ($secondhalf as $thing){
	?>
<div class="container-ov"><!--<a href="thing.php?thingid=<?php echo $thing['thingid']; ?>">--><img class="myImg" src="attachments/<?php echo $thing['thingattachmentid'] . '-' . $thing['filename']; ?>"><div class="overlay-ov"><div class="text1"><span class="author"><?php echo $thing['filename']; ?></div>
</div><!--</a>--></div>


<?php }
?>
</div>

<!--End section-->

	<div class="newthing">
		<form enctype="multipart/form-data" method="post" action="list.php">
			<input type="text" name="name" id="name" size="81" placeholder="Enter a thing name" value="<?php echo $name; ?>" />
			<br/>
			<label id="label" for="attachment">Add an image, PDF, etc.</label>
			<input id="attachment" name="attachment" type="file">
			<br/>
			<input type="submit" name="start" value="Create Thing" />
			<input type="submit" name="cancel" value="Cancel" />
		</form>
	</div>

	<!--modal-->
  <div class="modal" id="myModal">
    <!--The cose button-->
      <span class="close" onclick="document.getElementById('myModal').style.display='none'">&times;</span>
      <!--image-->
      <img class="modal-content" id="img01" alt="modal">

      <!--modal caption-->
      <div id="caption"></div>
    </div>

	<div class="include"><?php include 'include/footer.php'; ?></div>
</div>

	<script>/*
	$(document).ready(function(){
		$('#submitPic').click(function(){
			$('p').css("display", "inline-block");
		})
	},
	$('body:not(.newthing)').click(function(){
		$(".newthing").show();
				$('body').addClass('addimage');
				$(".newthing").toggleClass("opacity");
	})
)*/

	</script>
	<script src="modal.js"></script>
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
</body>
</html>
