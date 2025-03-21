<?php  
// Connect to the database  
session_start();
include 'server.php';  


if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to login page if not logged in
    exit();
}
// Prevent browser from caching the page
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");

 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $classCode = trim($_POST['classcode']);
    $user_id = $_SESSION['user_id'];

    // Check if class exists and get the creator's ID
    $query = "SELECT id, created_by FROM classes WHERE classCode = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $classCode);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $class_id = $row['id'];
        $creator_id = $row['created_by'];

        // Prevent the creator from joining their own class
        if ($user_id == $creator_id) {
            $_SESSION["error"] = "You are the creator of this class and cannot join as a member!";
        } else {
            // Check if user is already in the class
            $check_query = "SELECT * FROM class_members WHERE user_id = ? AND class_id = ?";
            $stmt = $conn->prepare($check_query);
            $stmt->bind_param("ii", $user_id, $class_id);
            $stmt->execute();
            $check_result = $stmt->get_result();

            if ($check_result->num_rows == 0) {
                // Add user to the class
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
header("Location: joinClass.php");
exit();
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

    <h2>Join an Existing Class</h2>  

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

    <!-- Join Class Form -->  
    <form action="joinClass.php" method="post">  
        <label for="class_code">Class Code:</label>  
        <input type="text" id="class_code" name="class_code" required>  
        <br><br>  
        <button type="submit">Join Class</button>  
    </form>  

    <br>  
    <a href="dashboard.php">Back</a>  
</body>  
</html>
