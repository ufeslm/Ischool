<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
  // Redirect to the login page if not logged in
  header("Location: admin_login.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome Admin</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .container {
      max-width: 900px;
      margin: 150px auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      text-align: center;
    }
    .dashboard-links {
      display: flex;
      flex-direction: column;
    }

    h2 {
      margin-bottom: 20px;
      text-align: center;
    }

    p {
      margin-bottom: 10px;
    }

    .logout {
      text-align: center;
      margin-top: 20px;
    }

    .logout a {
      color: #f44336;
      text-decoration: none;
    }

    .logout a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Welcome Admin</h2>
    <p>You are now logged in as <?php echo $_SESSION["username"]; ?>.</p>
    <!-- Add your admin dashboard content here -->

    <div class="dashboard-links">
      <a href="delete_requests.php">View Delete Requests</a>
      <a href="teachers.php">View Teachers</a>
      <a href="students.php">View Students</a>
      <a href="classes.php">View Classes</a>

    </div>

    <div class="logout">
      <a href="logout.php">Logout</a>
    </div>
  </div>
</body>
</html>

