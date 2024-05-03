<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["email"])) {
  // Redirect to the login page if not logged in
  header("Location: index.html");
  exit();
}

// Include database connection
include_once "connection.php";

// Get student's information from the database
$email = $_SESSION["email"];
$query = "SELECT * FROM students WHERE email = '$email'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $firstname = $row['firstname'];
  $lastname = $row['lastname'];
  $email = $row['email'];

  // Check if there's already a delete request for this student
  $query1 = "SELECT * FROM delete_requests WHERE user_id = {$row['id']} AND user_type = 'student'";
  $result1 = mysqli_query($conn, $query1);

  // Close database connection
  mysqli_close($conn);
} else {
  echo "Error fetching user information.";
  exit(); // Stop further execution if there's an error
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
</head>
<body>
  <div class="container">
    <h2>Profile Information</h2>
    <p><strong>First Name:</strong> <?php echo $firstname; ?></p>
    <p><strong>Last Name:</strong> <?php echo $lastname; ?></p>
    <p><strong>Email:</strong> <?php echo $email; ?></p>
    <a href="edit_profile.php">Edit Profile</a>
    <?php
      if ($result1 && mysqli_num_rows($result1) > 0) {
        echo "<p>Request already sent</p>";
      } else {
        echo "<a href='delete_profile.php'>Delete Profile</a>";
      }
    ?>
  </div>
</body>
</html>
