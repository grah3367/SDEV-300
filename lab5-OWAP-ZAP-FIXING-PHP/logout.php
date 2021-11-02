<?php
session_start();

session_destroy(); // destroy the session data
header("Location: login.html"); // redirect to the homepage.

?>