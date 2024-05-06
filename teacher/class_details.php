<?php
session_start();

// Check if the user is logged in as a teacher
if (!isset($_SESSION['teacher_id'])) {
    header("Location: my_classes.php"); // Redirect to login page if not logged in
    exit();
}

// Include database connection
include_once "connection.php";

// Check if the class ID is provided in the URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];

    // Fetch class details from database
    $class_query = "SELECT * FROM classes WHERE id = '$class_id' AND teacher_id = '" . $_SESSION['teacher_id'] . "'";
    $class_result = mysqli_query($conn, $class_query);

    if ($class_result && mysqli_num_rows($class_result) > 0) {
        $class_row = mysqli_fetch_assoc($class_result);
        echo "<h2>" . $class_row['class_name'] . "</h2>";
        echo "<p><strong>Description:</strong> " . $class_row['description'] . "</p>";
        echo "<p><strong>Mots Clés:</strong> " . $class_row['key_words'] . "</p>";
        echo "<p><strong>Les Prérequis:</strong> " . $class_row['pre_requirements'] . "</p>";

        // Link to My Students page
        echo "<a href='my_students.php?class_id=" . $class_row['id'] . "'>Mes étudiants</a><br>";
        echo "<a href='teacher_upload_form.php?class_id=" . $class_row['id'] . "'>Importer un nouveau chapitre</a><br>";
        echo "<a href='preview_chapters.php?class_id=" . $class_row['id'] . "'>Chapitres</a><br>";
        echo "<a href='update_class_info.php?class_id=" . $class_row['id'] . "'>Modifier les informatios du cours</a><br>";
        echo "<a href='announcements.php?class_id=" . $class_row['id'] . "'>Annonces</a><br>";
        echo "<a href='messages.php?class_id=" . $class_row['id'] . "'>Messages</a><br>";
    } else {
        echo "Cours introuvable ou vous n'êtes pas autorisé à afficher ce cours.";
    }
} else {
    echo "Requête invalide.";
}

// Close database connection
mysqli_close($conn);
?>
