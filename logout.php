<?php
session_start(); // Start the session

// Destroy the session and clear session data
session_unset(); // Remove all session variables
session_destroy(); // Destroy the session

// Redirect to login page
header('Location: index.php');
exit;
?>
