<?php
session_start(); // Ensure user session is active

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to download files.");
}

// Connect to MySQL
$conn = new mysqli("localhost", "root", "", "user_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate file ID
if (isset($_GET['id'])) {
    $file_id = intval($_GET['id']);
    $class_id = $_SESSION['class_id'];  // Get user's class

    // Fetch file details only if it belongs to the user's class
    $sql = "SELECT filename, filepath FROM files WHERE id = ? AND class_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $file_id, $class_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $file_path = $row['filepath'];

        // Check if file exists before downloading
        if (file_exists($file_path)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_path));
            readfile($file_path);
            exit;
        } else {
            die("File not found!");
        }
    } else {
        die("Access denied! File not available in your class.");
    }
} else {
    die("Invalid request.");
}
?>
