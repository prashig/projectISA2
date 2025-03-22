<?php
include 'server.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["classId"]) || empty($_POST["classId"])) {
        echo json_encode(["success" => false, "message" => "❌ Class ID is missing in request!"]);
        exit();
    }

    $noteTitle = $_POST["noteTitle"];
    $classId = intval($_POST["classId"]); 
    $uploadedBy = $_SESSION["user_id"];

    // see if classId exists in d classes table
    $classCheck = $conn->prepare("SELECT c_id FROM classes WHERE c_id = ?");
    $classCheck->bind_param("i", $classId);
    $classCheck->execute();
    $classCheck->store_result();

    if ($classCheck->num_rows == 0) {
        echo json_encode(["success" => false, "message" => "Class ID does not exist"]);
        exit();
    }

    // File Upload Handling
    $filePath = "uploads/" . basename($_FILES["noteFile"]["name"]);
    move_uploaded_file($_FILES["noteFile"]["tmp_name"], $filePath);

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO notes (noteTitle, filePath, uploadedBy, classId) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $noteTitle, $filePath, $uploadedBy, $classId);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Note uploaded successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Database insert error!"]);
    }
}
?>
