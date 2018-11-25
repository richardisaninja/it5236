<?php

// Import the application classes
  require_once('include/classes.php');
  // Create an instance of the Application class
  $app = new Application();
  $app->setup();

  

   $app->processLoginValidation($validation_key, $validationid, $errors);
 if(isset($_POST['submit'])){
     $validation_key = $_POST['validation'];
 }


?>
<html>
<head></head>
<body>
  <form method="POST" id="opt-form" action="otp.php">
    <iput type="text" name="username" placeholder="username">
    <input type="text" name="validation" placeholder="login validation key">
    <input type="submit" name="submit" value="submit">
  </form>
</body>
</html>
