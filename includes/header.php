<?php
// Start the session on every page for login logic later
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ElectroTech Store</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/print.css" media="print">
</head>
<body>

<header class="main-header">
    <div class="logo-container">
        <h1>ElectroTech</h1>
    </div>
    
    <nav class="main-nav">
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="products.php">Products</a></li> <li><a href="gallery.php">Gallery</a></li>
            <li><a href="video.php">Video</a></li>
            <li><a href="support.php">Support</a></li> <li><a href="calculator.php">Tools</a></li> <li><a href="about.php">About</a></li>
            
            <?php if(isset($_SESSION['user_id'])): ?>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="logout.php" class="btn-logout">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<main class="content-wrapper">