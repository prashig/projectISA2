<?php
include 'server.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$classCode = $_GET['classCode'] ?? '';
$user_id = $_SESSION['user_id'];

// Fetch class details
$query = "SELECT * FROM classes WHERE classCode = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $classCode);
$stmt->execute();
$result = $stmt->get_result();
$class = $result->fetch_assoc();

if (!$class) {
    die("Class not found!");
}

$classId = $class['c_id']; // Fetch correct class ID

// Check if the user is the creator
$isCreator = ($class['created_by'] == $user_id);

// Check if the user has joined the class
$query = "SELECT * FROM class_members WHERE user_id = ? AND class_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $user_id, $classId);
$stmt->execute();
$result = $stmt->get_result();
$isMember = $result->num_rows > 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $class['className']; ?></title>
    <link rel="stylesheet" href="style1.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #e4caa4;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h2 {
            color: #455763;
        }

        .btn {
            background-color: #455763;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin: 5px;
            transition: background 0.3s ease-in-out;
        }

        .btn:hover {
            background-color: #2e3f4c;
        }

        .dashboard-btn {
            display: block;
            width: fit-content;
            margin: 20px auto;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2><?php echo $class['className']; ?></h2>

        <?php if ($isCreator): ?>
            <p class="info">You are the creator of this class</p>
            <p><strong>Class Code:</strong> <?php echo htmlspecialchars($class['classCode']); ?></p>
            <a href="notes.php?classCode=<?php echo urlencode($classCode); ?>" class="btn">Upload Files</a>
            <a href="fetchNotes.php?classId=<?php echo $classId; ?>" class="btn">View Notes</a>
        <?php elseif ($isMember): ?>
            <p class="info">You have joined this class</p>
            <a href="viewNotes.php?classId=<?php echo $classId; ?>" class="btn">View Notes</a>

        <?php else: ?>
            <p class="info">You are not a member of this class.</p>
        <?php endif; ?>
    </div>
    <a href="dashboard.php" class="btn dashboard-btn">Back to Dashboard</a>
</body>

</html>