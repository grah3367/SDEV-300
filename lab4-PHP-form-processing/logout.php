<?php
session_start();

session_destroy(); // destroy the session data
header("Location: index.php"); // redirect to the homepage.

?>