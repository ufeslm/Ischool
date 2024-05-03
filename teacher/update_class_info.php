<?php
session_start();

// Check if the user is logged in as a teacher
if (!isset($_SESSION['teacher_id'])) {
    header("Location: teacher_login.php"); // Redirect to login page if not logged in
    exit();
}

// Include database connection
include_once "connection.php";

// Check if class_id is provided in the URL
if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];

    // Fetch class information for the specified class ID
    $class_query = "SELECT * FROM classes WHERE id = '$class_id'";
    $class_result = mysqli_query($conn, $class_query);
    if ($class_result && mysqli_num_rows($class_result) > 0) {
        $class_row = mysqli_fetch_assoc($class_result);
        $class_name = $class_row['class_name'];
        $description = $class_row['description'];
        $key_words = $class_row['key_words'];
        $pre_requirements = $class_row['pre_requirements'];
        // Other class information

        // Check if form is submitted for updating class info
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['class_name']) && isset($_POST['description']) && isset($_POST['key_words']) && isset($_POST['pre_requirements'])) {
            $new_class_name = $_POST['class_name'];
            $new_description = $_POST['description'];
            $new_key_words = $_POST['key_words'];
            $new_pre_requirements = $_POST['pre_requirements'];
            // Update class information in the database
            $update_query = "UPDATE classes SET class_name = '$new_class_name', description = '$new_description', key_words = '$new_key_words', pre_requirements = '$new_pre_requirements' WHERE id = '$class_id'";
            if (mysqli_query($conn, $update_query)) {
                echo "Class information updated successfully!";
                // Redirect to class details page or any other page as needed
                header("Location: class_details.php?class_id=" . $class_id);
                exit();
            } else {
                echo "Error updating class information: " . mysqli_error($conn);
            }
        }

        // Display the form for updating class information
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Update Class Information</title>
        </head>
        <body>
            <h2>Update Class Information</h2>
            <form action="" method="post">
                <label for="class_name">Class Name:</label>
                <input type="text" id="class_name" name="class_name" value="<?php echo $class_name; ?>" required><br><br>
                
                <label for="description">Description:</label><br>
                <textarea id="description" name="description" rows="4" cols="50" required><?php echo $description; ?></textarea><br><br>

                <label for="key_words">Key Words:</label>
                <input type="text" id="key_words" name="key_words" value="<?php echo $key_words; ?>" required><br><br>

                <label for="pre_requirements">Pre-Requirements:</label><br>
                <textarea id="pre_requirements" name="pre_requirements" rows="4" cols="50" required><?php echo $pre_requirements; ?></textarea><br><br>

                <!-- Add other input fields for updating class info as needed -->

                <input type="submit" value="Update Class Information">
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "Class not found.";
    }

    // Close database connection
    mysqli_close($conn);
} else {
    echo "Invalid request.";
}
?>
