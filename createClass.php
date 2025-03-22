<?php
// Connect to the database  
include 'server.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $className = trim($_POST['classname']);
    $classCode = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
    $created_by = $_SESSION['user_id'];


    $query = "INSERT INTO classes (className, classCode, created_by) VALUES ('$className', '$classCode', '$created_by')";

    if ($conn->query($query) === TRUE) {
        $_SESSION["success"] = "Class Created! Share this code: $classCode";
        $_SESSION["class_code"] = $classCode;
    } else {
        $_SESSION["error"] = "Error creating class!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Class</title>
    <link rel="stylesheet" href="style1.css">
</head>

<body>

    <h2>Create a New Class</h2>
    <!-- clss created or not -->
    <?php
    if (isset($_SESSION["success"])) {
        echo '<p style="color: green;">' . $_SESSION["success"] . '</p>';
        unset($_SESSION["success"]);
    }

    if (isset($_SESSION["error"])) {
        echo '<p style="color: red;">' . $_SESSION["error"] . '</p>';
        unset($_SESSION["error"]);
    }
    ?>
    <!--  show d class code -->
    <?php
    if (isset($_SESSION["class_code"])) {
        echo "<p>Class Code: " . $_SESSION["class_code"] . "</p>";
        unset($_SESSION["class_code"]);
    }
    ?>
    <!-- Form 2 create a class -->
    <form class="formcreate" action="createClass.php" method="post">
        <label for="class_name">Class Name:</label>
        <input type="text" id="classname" name="classname" required>
        <br><br>
        <button type="submit">Create Class</button>
    </form>

    <br>
    <a href="dashboard.php">Back</a>
</body>

</html>