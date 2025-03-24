<?php


include 'server.php'; 


if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $className = trim($_POST['classname']); 
    $classCode = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6)); 
    // Get the logged-in user's ID
    $created_by = $_SESSION['user_id']; 

    // Insert the new class into the database
    $query = "INSERT INTO classes (className, classCode, created_by) VALUES ('$className', '$classCode', '$created_by')";

    if ($conn->query($query) === TRUE) {
        $_SESSION["success"] = "Class Created! Share this code: $classCode"; 
        // Store the class code
        $_SESSION["class_code"] = $classCode; 
    } else {
        $_SESSION["error"] = "Error creating class: " . $conn->error; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Class</title>
   
</head>
<style>
        body {
            background-color: #f8f9fa; 
        }
        h2{
            color:#455763;
            align-items: center;
        }
        .form {
            background-color: #e4caa4; 
            padding: 20px;
            border-radius: 8px;
            
            max-width: 400px;
            margin: auto;
        }
        .colorbtn {
            background-color: #455763; 
            color: white;
            border: none;
            margin:5px;
            border-radius:3px;
            padding: 5px;
        }
        .colorbtn:hover {
            background-color:rgb(141, 192, 221); 
        }
        .dashbtn{
            background:#455763;
            padding:15px;
            border-radius:10px;
            border: none;
            color:white;
            margin:20px;
        }
       
    </style>

<body>

    <h2>Create a New Class</h2>

    <!-- Show success or error messages -->
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

<form method="POST" action="createClass.php" class="form">
        <h3 class="mb-3 text-center">Create Class</h3>

        <div class="mb-3">
            <label for="classname" class="form-label">Class Name:</label>
            <input type="text" id="classname" name="classname" class="form-control" required>
            
        <button type="submit" class="btn colorbtn w-100">Create Class</button>
        </div>

    </form>

    <button type="button" class="btn dashbtn w-100" onclick="window.location.href='dashboard.php'">Go to Dashboard</button>

    

</body>
</html>
