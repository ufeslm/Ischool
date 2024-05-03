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

    // Fetch class details from database to display class name
    $class_query = "SELECT class_name FROM classes WHERE id = '$class_id' AND teacher_id = '" . $_SESSION['teacher_id'] . "'";
    $class_result = mysqli_query($conn, $class_query);
    $class_name = mysqli_fetch_assoc($class_result)['class_name'];

    if ($class_result && mysqli_num_rows($class_result) > 0) {
        echo "<h2>Announcements for Class: " . $class_name . "</h2>";

        // Display form to add new announcement
        echo "<form method='POST' action='add_announcement.php'>";
        echo "<input type='hidden' name='class_id' value='$class_id'>";
        echo "<textarea name='announcement' placeholder='Write your announcement here...' required></textarea><br>";
        echo "<input type='submit' value='Add Announcement'>";
        echo "</form>";

        // Check if form is submitted to add new announcement
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['announcement'])) {
            $announcement = mysqli_real_escape_string($conn, $_POST['announcement']);

            // Insert new announcement into database
            $insert_query = "INSERT INTO announcements (class_id, announcement) VALUES ('$class_id', '$announcement')";
            if (mysqli_query($conn, $insert_query)) {
                echo "Announcement added successfully!";
            } else {
                echo "Error adding announcement: " . mysqli_error($conn);
            }
        }

        // Fetch announcements for this class from database
        $announcements_query = "SELECT * FROM announcements WHERE class_id = '$class_id' ORDER BY created_at DESC";
        $announcements_result = mysqli_query($conn, $announcements_query);

        // Display existing announcements
        if ($announcements_result && mysqli_num_rows($announcements_result) > 0) {
            echo "<h3>Existing Announcements:</h3>";
            while ($announcement_row = mysqli_fetch_assoc($announcements_result)) {
                echo "<p><strong>Posted on:</strong> " . $announcement_row['created_at'] . "</p>";
                echo "<p>" . $announcement_row['announcement'] . "</p>";
                echo "<hr>";
            }
        } else {
            echo "<p>No announcements yet.</p>";
        }
    } else {
        echo "Class not found or you don't have permission to view announcements for this class.";
    }   
} else {
    echo "Invalid request.";
}

// Close database connection
mysqli_close($conn);
?>
