<?php
session_start(); // Start the session

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the login page or homepage
header("Location: task7.php"); // Change 'index.php' to the appropriate page if necessary
exit();
?>
