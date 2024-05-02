<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["email"])) {
  // Redirect to the login page if not logged in
  header("Location: index.html");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome</title>
</head>
<body>
  <div class="container">
    <h2>Welcome to the Website</h2>
    <p>You are now logged in. Enjoy your stay!</p>
    <a href="logout.php">Logout</a>
    <a href="classes.php">enroll to class</a>
    <a href="my_classes.php">My Classes</a>
  </div>
</body>
</html>
