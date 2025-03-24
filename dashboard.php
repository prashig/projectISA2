<?php
include 'server.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = isset($_SESSION["user_name"]) ? htmlspecialchars($_SESSION["user_name"]) : "User";

// Get the user's created classes
$query_created = "SELECT className, classCode FROM classes WHERE created_by = ?";
$stmt = $conn->prepare($query_created);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result_created = $stmt->get_result();

// Get the user's joined classes

$query_joined = "SELECT c.className, c.classCode FROM class_members cm 
                 JOIN classes c ON cm.class_id = c.c_id WHERE cm.user_id = ?";

$stmt = $conn->prepare($query_joined);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result_joined = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style1.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand me-auto" href="dashboard.php">Classroom</a>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                    <li class="nav-item"><a class="nav-link mx-lg-2" href="dashboard.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link mx-lg-2" href="signup.php">Sign Up</a></li>
                    <li class="nav-item"><a class="nav-link mx-lg-2" href="createClass.php">Create</a></li>
                    <li class="nav-item"><a class="nav-link mx-lg-2" href="joinClass.php">Join</a></li>
                </ul>
            </div>
            <a href="index.php" class="login-button">Logout</a>
        </div>
    </nav>

    <div class="container mt-5 pt-5">
        <h2>Your Created Classes</h2>
        <?php
        if ($result_created->num_rows > 0) {
            while ($row = $result_created->fetch_assoc()) {
                echo '<div class="card mb-3" style="width: 80rem;">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . htmlspecialchars($row['className']) . '</h5>';
                echo '<p class="card-text">Class Code: ' . htmlspecialchars($row['classCode']) . '</p>';
                echo '<a href="classPage.php?classCode=' . urlencode($row['classCode']) . '" class="btn btn-success">View Notes</a>';
                echo '</div></div>';
            }
        } else {
            echo '<p>No classes created yet.</p>';
        }
        ?>

        <h2>Your Joined Classes</h2>
        <?php
        if ($result_joined->num_rows > 0) {
            while ($row = $result_joined->fetch_assoc()) {
                echo '<div class="card mb-3" style="width: 80rem;">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . htmlspecialchars($row['className']) . '</h5>';
                echo '<a href="classPage.php?classCode=' . urlencode($row['classCode']) . '" class="btn btn-success">View Notes</a>';
                echo '</div></div>';
            }
        } else {
            echo '<p>You have not joined any classes yet.</p>';
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>