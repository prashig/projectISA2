<?php

include 'server.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $classCode = trim($_POST['classcode']);
    $user_id = $_SESSION['user_id'];

    // Check if class exists and get the creator's ID
    $query = "SELECT c_id, created_by FROM classes WHERE classCode = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $classCode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $class_id = $row['c_id'];
        $creator_id = $row['created_by'];

        // prevent the creator from joining their own class
        if ($user_id == $creator_id) {
            $_SESSION["error"] = "You are the creator of this class and cannot join as a member!";
        } else {
            // check if user is already in the class
            $check_query = "SELECT * FROM class_members WHERE user_id = ? AND class_id = ?";
            $stmt = $conn->prepare($check_query);
            $stmt->bind_param("ii", $user_id, $class_id);
            $stmt->execute();
            $check_result = $stmt->get_result();

            if ($check_result->num_rows == 0) {
                // add user to the class
                $insert_query = "INSERT INTO class_members (user_id, class_id) VALUES (?, ?)";
                $stmt = $conn->prepare($insert_query);
                $stmt->bind_param("ii", $user_id, $class_id);
                if ($stmt->execute()) {
                    $_SESSION["success"] = "Successfully joined the class!";
                } else {
                    $_SESSION["error"] = "Error joining the class.";
                }
            } else {
                $_SESSION["error"] = "You are already in this class.";
            }
        }
    } else {
        $_SESSION["error"] = "Invalid class code!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Class</title>
    <link rel="stylesheet" href="style1.css">
</head>

<body>
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

    <form class="form" action="joinClass.php" method="post">
    <h3 class="mb-3 text-center">Join</h3>
        <label for="classcode">Class Code:</label>
        <input type="text" id="classcode" name="classcode" required>
        <br><br>
        <button type="submit"class="btn colorbtn w-100">Join Class</button>
    </form>



    <br>
    <button type="button" class="btn dashbtn w-100" onclick="window.location.href='dashboard.php'">Go to Dashboard</button>

</body>

</html>
