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

        // Link to Inbox and Sent Messages
        echo "<a href='inbox.php?class_id=" . $class_row['id'] . "'>Inbox</a><br>";
        echo "<a href='sent_messages.php?class_id=" . $class_row['id'] . "'>Sent Messages</a><br>";
    } else {
        echo "Class not found or you don't have permission to view this class.";
    }   
} else {
    echo "Invalid request.";
}

// Close database connection
mysqli_close($conn);
?>
