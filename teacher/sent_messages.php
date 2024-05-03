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
        echo "<h2>Sent Messages</h2>";

        // Fetch messages and replies for this class
        $messages_query = "SELECT m.m_id AS message_id, m.sent_at, m.message_content, s.firstname, s.lastname, r.reply_message, r.replied_at
            FROM messages m
            INNER JOIN students s ON s.id = m.sender_id
            LEFT JOIN replies r ON r.message_id = m.m_id
            WHERE m.class_id = '$class_id' AND r.teacher_id = '" . $_SESSION['teacher_id'] . "'";
        $messages_result = mysqli_query($conn, $messages_query);

        if ($messages_result && mysqli_num_rows($messages_result) > 0) {
            while ($message_row = mysqli_fetch_assoc($messages_result)) {
                echo "<div>";
                echo "<p><strong>From:</strong> " . $message_row['firstname'] . " " . $message_row['lastname'] ."</p>";
                echo "<p><strong>Sent:</strong> " . $message_row['sent_at'] . "</p>";
                echo "<p><strong>Message:</strong> " . $message_row['message_content'] . "</p>";
                if ($message_row['reply_message']) {
                    echo "<p><strong>Teacher Reply:</strong> " . $message_row['reply_message'] . "</p>";
                    echo "<p><strong>Reply Sent:</strong> " . $message_row['replied_at'] . "</p>";
                } else {
                    echo "<p>No reply yet.</p>";
                }
                echo "</div>";
            }
        } else {
            echo "<p>No messages with replies found.</p>";
        }
    } else {
        echo "Class not found or you don't have permission to view this class.";
    }   
} else {
    echo "Invalid request.";
}

// Close database connection
mysqli_close($conn);
?>
