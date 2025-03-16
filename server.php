<?php
session_start();

// Database Connection
$conn = new mysqli("localhost", "root", "", "user_db");



// SIGNUP
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["signup"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash Password

    // Check if email already exists
    $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "<script>alert('Error: Email already exists!'); window.location='signup.php';</script>";
    } else {
        // Insert User
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);

        if ($stmt->execute()) {
            echo "<script>alert('Signup successful!'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Error: Something went wrong!'); window.location='signup.php';</script>";
        }
    }
}

// LOGIN
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $email = $_POST["email"];
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
    } else {
        echo "<script>alert('Invalid credentials!'); window.location='index.php';</script>";
    }
}

// LOGOUT
if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: index.php");
}
