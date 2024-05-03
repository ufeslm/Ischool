<?php
session_start();

// Check if the user is logged in as a student
if (!isset($_SESSION['student_id'])) {
    header("Location: welcome.php"); // Redirect to welcome page if not logged in
    exit();
}

// Include database connection
include_once "connection.php";

// Fetch available classes from database
$class_query = "SELECT * FROM classes";
$class_result = mysqli_query($conn, $class_query);

// Display available classes as links
if (mysqli_num_rows($class_result) > 0) {
    echo "<h2>Available Classes for Enrollment</h2>";
    echo "<div>";
    
    // Search form
    echo "<form action='search_classes.php' method='GET'>";
    echo "<label for='search'>Search:</label>";
    echo "<input type='text' id='search' name='search' placeholder='Search by name or keywords'>";
    echo "<input type='submit' value='Search'>";
    echo "</form>";
    
    while ($class_row = mysqli_fetch_assoc($class_result)) {
        echo "<a href='enroll_page.php?class_id=" . $class_row['id'] . "'>" . $class_row['class_name'] . "</a> | ";
    }
    echo "</div>";
} else {
    echo "No classes available for enrollment.";
}

// Close database connection
mysqli_close($conn);
?>
