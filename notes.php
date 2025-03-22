<?php
session_start();
include 'server.php'; // Ensure this connects to the database

if (!isset($_GET['classCode'])) {
    die("⚠️ Error: Class Code is missing from the URL!");
}

$classCode = $_GET['classCode'];

// Fetch the corresponding class ID
$stmt = $conn->prepare("SELECT c_id FROM classes WHERE classCode = ?");
$stmt->bind_param("s", $classCode);
$stmt->execute();
$result = $stmt->get_result();
$classRow = $result->fetch_assoc();
$classId = $classRow ? $classRow['c_id'] : null;

if (!$classId) {
    die("⚠️ Error: No class found for this Class Code!");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
    <title>Notes</title>
    <!-- Add jQuery before your script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="main.js"></script>

</head>
<body>
    <input type="hidden" id="classId" value="<?php echo htmlspecialchars($classId); ?>">

    <form id="uploadNoteForm" enctype="multipart/form-data">
        <label for="noteTitle">Note Title:</label>
        <input type="text" id="noteTitle" name="noteTitle" required><br><br>

        <label for="noteFile">Upload File:</label>
        <input type="file" id="noteFile" name="noteFile" required><br><br>

        <button type="submit">Upload Note</button>
    </form>
   

    <div id="message"></div>
    <div id="notesList"></div>
</body>
</html>



