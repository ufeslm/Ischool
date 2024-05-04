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
        echo "<h2>Boîte de réception</h2>";

        // Fetch messages from students for this class
        $messages_query = "SELECT * FROM messages m
        INNER JOIN students s ON s.id = m.sender_id
        WHERE class_id = '$class_id'";
        $messages_result = mysqli_query($conn, $messages_query);

        if ($messages_result && mysqli_num_rows($messages_result) > 0) {
            while ($message_row = mysqli_fetch_assoc($messages_result)) {
                echo "<div>";
                echo "<p><strong>De:</strong> " . $message_row['firstname'] . " " . $message_row['lastname'] ."</p>";
                echo "<p><strong>Envoyé le:</strong> " . $message_row['sent_at'] . "</p>";
                echo "<p><strong>Message:</strong> " . $message_row['message_content'] . "</p>";
                echo "<form action='reply_messages.php' method='post'>";
                echo "<input type='hidden' name='class_id' value='" . $class_id . "'>";
                echo "<input type='hidden' name='message_id' value='" . $message_row['m_id'] . "'>";
                echo "<input type='hidden' name='student_id' value='" . $message_row['sender_id'] . "'>";
                echo "<textarea name='reply_message' placeholder='Répondre à l'étudiant' required></textarea><br>";
                echo "<input type='submit' value='Envoyer la réponse'>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "<p>Aucun message dans la boîte de réception.</p>";
        }
    } else {
        echo "Cours introuvable ou vous n'êtes pas autorisé à afficher ce cours.";
    }
} else {
    echo "Requête invalide.";
}

// Close database connection
mysqli_close($conn);
?>
