<?php
// includes/db.php

$servername = "sql12.freesqldatabase.com";
$username = "sql12810309";        // Default XAMPP username
$password = "h7W2ttTqdv";            // Default XAMPP password (leave empty)
$dbname = "sql12810309";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>