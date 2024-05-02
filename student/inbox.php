<?php
session_start();

// Check if the user is logged in as a student
if (!isset($_SESSION['student_id'])) {
    header("Location: my_classes.php"); // Redirect to login page if not logged in
    exit();
}

// Include database connection
include_once "connection.php";

// Check if the class ID is provided in the URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];

    // Fetch class details from database
    $class_query = "SELECT * FROM classes WHERE id = '$class_id'";
    $class_result = mysqli_query($conn, $class_query);

    if ($class_result && mysqli_num_rows($class_result) > 0) {
        $class_row = mysqli_fetch_assoc($class_result);
        echo "<h2>" . $class_row['class_name'] . "</h2>";

        // Fetch messages and replies from teacher for this class and student
        $messages_query = "SELECT m.message_content, m.sent_at,
                                  r.reply_message AS teacher_reply, r.replied_at AS replied_at
                           FROM messages m
                           LEFT JOIN replies r ON m.m_id = r.message_id   
                           WHERE m.class_id = '$class_id' AND m.sender_id <> '" . $_SESSION['student_id'] . "'";
        $messages_result = mysqli_query($conn, $messages_query);

        if ($messages_result && mysqli_num_rows($messages_result) > 0) {
            while ($message_row = mysqli_fetch_assoc($messages_result)) {
                echo "<div>";
                echo "<p><strong>Sent:</strong> " . $message_row['sent_at'] . "</p>";
                echo "<p><strong>Message:</strong> " . $message_row['message_content'] . "</p>";

                // Check if there is a reply from the teacher
                if ($message_row['teacher_reply'] && $message_row['replied_at']) {
                    echo "<p><strong>Teacher's Reply:</strong> " . $message_row['teacher_reply'] . "</p>";
                    echo "<p><strong>Replied At:</strong> " . $message_row['replied_at'] . "</p>";
                } else {
                    echo "<p>No reply from teacher yet.</p>";
                }

                echo "</div>";
            }
        } else {
            echo "<p>No messages in the inbox.</p>";
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
