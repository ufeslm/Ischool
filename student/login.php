<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Include database connection
  include_once "connection.php";

  // Get form data
  $username_email = $_POST["email"];
  $password = $_POST["password"];

  // Validate and sanitize inputs (you can add more validation here)
  $username_email = filter_var($username_email, FILTER_SANITIZE_STRING);

  // Check if the username/email and password match in the database
  $query = "SELECT * FROM students WHERE email='$username_email' AND password='".md5($password)."'";
  $result = mysqli_query($conn, $query);
  $count = mysqli_num_rows($result);

  if ($count == 1) {

    $row = mysqli_fetch_array($result);
    $student_id = $row['id'];
    // Set session variables
    $_SESSION["email"] = $username_email;
    $_SESSION["student_id"] = $student_id;

    // Redirect to welcome page after successful login
    header("Location: welcome.php");
    exit();
  } else {
    echo "Invalid username/email or password.";
  }

  // Close database connection
  mysqli_close($conn);
}
?>
