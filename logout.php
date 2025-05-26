<?php
session_start();
session_unset(); // Clear all session variables
session_destroy(); // Destroy the session itself

// Redirect back to the home page
header("Location: index.php");
exit();
?>
