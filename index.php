<?php include('server.php') ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <div class="form-box">
        <div class="form ">
            <div class="form-content">
                <!-- <form action="server.php" method="post" >
               <h2>Login</h2>
               <input type="text" name="name"   placeholder="Name">
               <br><br>
               <input type="email" name="email" placeholder="email">
               <br><br>
              
               <input type="password" name="ct" placeholder="password">
               <br><br>
               
               <input type="submit" value="Log In" class="btn">
               <p>Don't have an account?<a href="signup.php">Sign Up</a></p>
           </form > -->
                <form action="server.php" method="post">
                    <h2>Login</h2>
                   
                    <input type="email" name="email" placeholder="Email" required><br><br>
                    <input type="password" name="password" placeholder="Password" required><br><br>
                    <input type="submit" name="login" value="Log In" class="btn">
                    <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
                </form>

            </div>

        </div>

        <img src="https://cdn.pixabay.com/photo/2020/02/06/20/48/uni-4825471_640.jpg" alt="img" class="image">

    </div>



</body>

</html>