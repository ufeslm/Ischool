<?php
session_start();

// Check if the user is logged in as a teacher
if (!isset($_SESSION['teacher_id'])) {
    header("Location: class_details.php"); // Redirect to login page if not logged in
    exit();
}

// Include database connection
include_once "connection.php";

// Initialize class ID
$class_id = $_GET['class_id'];




// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importer le chapitre</title>
</head>
<body>
    <h2>Importer le chapitre</h2>
    <form action="upload_chapter.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
        <label for="chapter_name">Intitulé Du Chapitre:</label>
        <input type="text" id="chapter_name" name="chapter_name" required><br><br>

        <label for="chapter_file">Importer Le PDF:</label>
        <input type="file" id="chapter_file" name="chapter_file" accept=".pdf" required><br><br>

        <input type="submit" value="Importer">
    </form>
</body>
</html>
