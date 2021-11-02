<?php
session_start();

session_destroy(); // destroy the session data
header("Location: index.html"); // redirect to the homepage.

?>