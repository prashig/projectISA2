<?php
include 'server.php';

if (!isset($_GET["classId"]) || empty($_GET["classId"])) {
    die("\u26a0\ufe0f Error: Class ID is missing!");
}

$classId = intval($_GET["classId"]);
$user_id = $_SESSION['user_id'];

// fetch class details
$query = "SELECT created_by FROM classes WHERE c_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $classId);
$stmt->execute();
$result = $stmt->get_result();
$class = $result->fetch_assoc();

if (!$class) {
    die("\u26a0\ufe0f Error: Class not found!");
}

$isCreator = ($class['created_by'] == $user_id);

// fetch notes for the class
$query = "SELECT noteId, noteTitle, filePath FROM notes WHERE classId = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $classId);
$stmt->execute();
$result = $stmt->get_result();
$notes = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Notes</title>
    <link rel="stylesheet" href="style1.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #e4caa4;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 50%;
        }
        h2 {
            color: #455763;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background: #fff;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn {
            background-color: #455763;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            transition: background 0.3s ease-in-out;
        }
        .btn:hover {
            background-color: #2e3f4c;
        }
        .delete-btn {
            background-color: #dc3545;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Class Notes</h2>
        <?php if (empty($notes)): ?>
            <p style="color: red;">No notes found for this class.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($notes as $note): ?>
                    <li>
                         <a href="<?php echo $note['filePath']; ?>" download><?php echo $note['noteTitle']; ?></a>
                        <?php if ($isCreator): ?>
                            <form action="deleteNote.php" method="post" style="display:inline;">
                                <input type="hidden" name="noteId" value="<?php echo $note['noteId']; ?>">
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <br>
        <a href="dashboard.php" class="btn">Back to Dashboard</a>
    </div>
</body>
</html>
