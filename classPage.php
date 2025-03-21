<?php

include 'server.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$classCode = $_GET['classCode'] ?? '';
$user_id = $_SESSION['user_id'];

// Fetch class details
$query = "SELECT * FROM classes WHERE classCode = '$classCode'";
$result = $conn->query($query);
$class = $result->fetch_assoc();

if (!$class) {
    die("Class not found!");
}

// Check if the user is the creator
$isCreator = ($class['created_by'] == $user_id);

// Check if the user has joined the class
$query = "SELECT * FROM class_members WHERE user_id = '$user_id' AND class_id = '{$class['id']}'";
$result = $conn->query($query);
$isMember = $result->num_rows > 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $class['className']; ?></title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <h2><?php echo $class['className']; ?></h2>

    <?php if ($isCreator): ?>
        <h3>You are the creator of this class</h3>
        <p><strong>Class Code:</strong> <?php echo htmlspecialchars($class['classCode']); ?></p>
        <a href="upload.php?classCode=<?php echo $classCode; ?>">Upload Files</a>
        <a href="comments.php?classCode=<?php echo $classCode; ?>">View Comments</a>
    <?php elseif ($isMember): ?>
        <h3>You have joined this class</h3>
        <a href="read.php?classCode=<?php echo $classCode; ?>">View Files</a>
        <a href="download.php?classCode=<?php echo $classCode; ?>">Download Materials</a>
    <?php else: ?>
        <h3>You are not a member of this class.</h3>
    <?php endif; ?>
    
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
