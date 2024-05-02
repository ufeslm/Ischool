<?php
session_start();

// Check if the user is logged in as a teacher
if (!isset($_SESSION['teacher_id'])) {
    header("Location: welcome.php"); // Redirect to login page if not logged in
    exit();
}

// Include database connection
include_once "connection.php";

// Get teacher ID from session
$teacher_id = $_SESSION['teacher_id'];

// Fetch classes created by the teacher from database
$classes_query = "SELECT * FROM classes WHERE teacher_id = '$teacher_id'";
$classes_result = mysqli_query($conn, $classes_query);

// Display classes as links
if (mysqli_num_rows($classes_result) > 0) {
    echo "<h2>Classes Created by You</h2>";
    while ($class_row = mysqli_fetch_assoc($classes_result)) {
        echo "<a href='class_details.php?class_id=" . $class_row['id'] . "'>" . $class_row['class_name'] . "</a><br>";
    }
} else {
    echo "You have not created any classes yet.";
}

// Close database connection
mysqli_close($conn);
?>
