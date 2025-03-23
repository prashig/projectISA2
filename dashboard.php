<?php

// session_start();


include 'server.php';  


if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

$user_name = isset($_SESSION["user_name"]) ? htmlspecialchars($_SESSION["user_name"]) : "User";

// Get the user's created classes from the database
$user_id = $_SESSION['user_id']; 

// Run the query to fetch classes
$query = "SELECT className, classCode FROM classes WHERE created_by = '$user_id'";
$result = $conn->query($query); 
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
   
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style1.css">
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
                  <a class="nav-link mx-lg-2 " href="signup.php">sign Up</a>
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
          <a href="index.php" class="login-button">log In</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        </div>
      </nav>
     
<!-- welcm prt -->
 
<div class="welcome ">
<div class="card text-center p-3" style="width: 74rem;">
  
  <div class="card-body">
    <h3 class="card-title">Welcome,!</h3><p class="card-text"> <?php echo $user_name; ?></p>
    
    
    
    <!-- <a href="logout.php" class="btn btn-primary">Log Out</a> -->
  </div>
</div>
</div>
 <!-- welcm part ends -->

<div class="container  mt-5 pt-5" >
  <h2>Your  Classes</h2>

    <!-- Check if the user has created any classes -->
    <?php
    if ($result->num_rows > 0) {
        // Loop through each class and display it in a Bootstrap card
        while ($row = $result->fetch_assoc()) {
            echo '<div class="card" style="width: 80rem; margin-bottom: 20px;">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($row['className']) . '</h5>';
            echo '<p class="card-text">Class Code: ' . htmlspecialchars($row['classCode']) . '</p>';
            echo '<a href="notes.php?classCode=' . htmlspecialchars($row['classCode']) . '" class="btn btn-primary">Upload Notes</a>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p>No classes created yet.</p>';
    }
    ?>   
</div>





 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>  
