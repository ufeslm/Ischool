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
  <title>Bienvenu</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <h2>Bienvenu sur le site Web</h2>
    <p>Vous êtes maintenant connecté!</p>
    <a href="logout.php">Se déconnecter</a>
    <a href="add_class.php">Ajouter Un Cours</a>
    <a href="my_classes.php">Mes Cours</a>
    <a href="profile.php">Profil</a>
  </div>
</body>
</html>
