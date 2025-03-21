<?php

$_SESSION = []; // Clear session data

if (ini_get("session.use_cookies")) {
    setcookie(session_name(), '', time() - 42000, '/'); // Delete session cookie
}

session_destroy(); // Destroy session
header("Location: index.php");
exit();

?>
