<?php
session_start(); // Start session for authentication

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to view files.");
}

// Connect to MySQL
$conn = new mysqli("localhost", "root", "", "user_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get class ID from session (assuming user has joined a class)
$class_id = $_SESSION['class_id'];  

// Fetch only files related to the joined class
$sql = "SELECT id, filename FROM files WHERE class_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $class_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Classroom Files</title>
</head>
<body>
    <h2>Available Files</h2>
    <table border="1">
        <tr>
            <th>Filename</th>
            <th>Download</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['filename']); ?></td>
                <td><a href="download.php?id=<?php echo $row['id']; ?>">Download</a></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
