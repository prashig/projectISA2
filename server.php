<?php
session_start();

// Hosting Database Credentials
$servername = "sql103.infinityfree.com"; 
$username = "if0_38576566"; 
$password = "pwdJXUKBnpjCiHS"; 
$dbname = "if0_38576566_user_db";

// Database Connection
// $conn = new mysqli("localhost", "root", "", "user_db");

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// check connection
if ($conn->connect_error) {
    die(" Connection failed: " . $conn->connect_error);
}

// SIGNUP Logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["signup"])) {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); 

    // Check if email already exists
    $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "<script>alert(' Email already exists!'); window.location='signup.php';</script>";
        exit();
    } else {
        // Insert User
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);

        if ($stmt->execute()) {
            echo "<script>alert(' Signup successful!'); window.location='index.php';</script>";
            exit();
        } else {
            echo "<script>alert(' Error: Something went wrong!'); window.location='signup.php';</script>";
            exit();
        }
    }
}

// LOGIN Logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Fetch user
    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["name"];
        echo "<script>alert('Login successful!'); window.location='dashboard.php';</script>";
        exit();
    } else {
        echo "<script>alert(' Invalid credentials!'); window.location='index.php';</script>";
        exit();
    }
}
?>
