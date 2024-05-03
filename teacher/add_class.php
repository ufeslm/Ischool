<?php
session_start();

// Check if the user is logged in as a teacher
if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Include database connection
include_once "connection.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $class_name = $_POST['class_name'];
    $teacher_id = $_SESSION['teacher_id']; // Assuming teacher ID is set in session upon login
    $description = $_POST['description'];
    $keywords = $_POST['keywords'];
    $pre_requirements = $_POST['pre_requirements'];

    // Insert new class into database
    $insert_sql = "INSERT INTO classes (class_name, teacher_id, description, key_words, pre_requirements) VALUES ('$class_name', '$teacher_id', '$description', '$keywords', '$pre_requirements')";
    if (mysqli_query($conn, $insert_sql)) {
        echo "Class added successfully!";
        header("Location: welcome.php");
    } else {
        echo "Error adding class: " . mysqli_error($conn);
    }
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add New Class</title>
</head>
<body>
<h2>Add New Class</h2>
<form method="post" action="add_class.php">
    <label for="class_name">Class Name:</label>
    <input type="text" id="class_name" name="class_name" required><br><br>

    <label for="description">Description:</label><br>
    <textarea id="description" name="description" rows="4" cols="50" required></textarea><br><br>

    <label for="keywords">Keywords:</label>
    <input type="text" id="keywords" name="keywords"><br><br>

    <label for="pre_requirements">Pre-Requirements:</label><br>
    <textarea id="pre_requirements" name="pre_requirements" rows="4" cols="50"></textarea><br><br>

    <input type="submit" value="Add Class">
</form>
</body>
</html>
