<?php
include 'server.php';  

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to login page if not logged in
    exit();
}
// Prevent browser from caching the page
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style1.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <!-- navbar srts -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand me-auto " href="dashboard.php">Classroom</a>

            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Classroom</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link n mx-lg-2 " aria-current="page" href="dashboard.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2 " href="createClass.php">Create</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2 " href="joinClass.php">Join</a>
                        </li>



                    </ul>

                </div>
            </div>
            <a href="logout.php" class="login-button">logout</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <!-- ends -->
    
<div class="container mt-5 pt-5">
    <h2 class="mt-5 mb-3">Classes You Created</h2>
    <div class="list-group">
        <?php
      
        $user_id = $_SESSION['user_id'];

        // Fetch classes created by the user
        $query = "SELECT * FROM classes WHERE created_by = '$user_id'";
        $result = $conn->query($query);

        while ($row = $result->fetch_assoc()) {
            echo '<a href="classPage.php?classCode=' . $row['classCode'] . '" class="list-group-item list-group-item-action">' . $row['className'] . '</a>';
        }
        ?>
    </div>

    <h2 class="mt-5 mb-3">Classes You Joined</h2>
    <div class="list-group">
        <?php
        // Fetch classes the user has joined
        $query = "SELECT c.* FROM class_members cm 
                  JOIN classes c ON cm.class_id = c.c_id 
                  WHERE cm.user_id = '$user_id'";
        $result = $conn->query($query);

        while ($row = $result->fetch_assoc()) {
            echo '<a href="classPage.php?classCode=' . $row['classCode'] . '" class="list-group-item list-group-item-action">' . $row['className'] . '</a>';
        }
        ?>
    </div>
</div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>


