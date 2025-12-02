<?php
// pages/dashboard.php
include '../includes/header.php';

// SECURITY CHECK: If user is not logged in, kick them out
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login
    exit();
}
?>

<div class="dashboard-container" style="max-width: 800px; margin: 0 auto; padding: 20px;">
    <h2>Member Dashboard</h2>
    <div class="welcome-box" style="background: #e2e6ea; padding: 20px; border-radius: 5px;">
        <h3>Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h3>
        <p>You have successfully accessed the protected area.</p>
    </div>

    <br>
    
    <a href="logout.php" class="btn-logout" style="background: red; color: white; padding: 10px 20px; text-decoration: none;">Logout</a>
</div>

<?php include '../includes/footer.php'; ?>