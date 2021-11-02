<?php
session_start();

session_destroy(); // destroy the session data
header("Location: login.php"); // redirect to the homepage.

?>