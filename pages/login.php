<?php
// pages/login.php
include '../includes/header.php';
include '../includes/db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // 1. Fetch user by username
    $stmt = $conn->prepare("SELECT user_id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        
        // 2. Verify Password 
        if (password_verify($pass, $row['password'])) {
            // 3. Start Session
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            
            // Redirect to the protected page
            header("Location: dashboard.php");
            exit();
        } else {
            $message = "<div class='error-msg'>Invalid Username or password.</div>";
        }
    } else {
        $message = "<div class='error-msg'>Invalid Username or password.</div>";
    }
    $stmt->close();
}
?>

<link rel="stylesheet" href="../css/login.css">

<div class="login-container">
    <h2>Login</h2>
    <?php echo $message; ?>
    
    <form action="login.php" method="POST" class="login-form">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required placeholder="Enter your username">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required placeholder="Enter your password">
        </div>
        <button type="submit" class="btn-submit">Login</button>
    </form>
    
    <p class="register-link">Don't have an account? <a href="register.php">Register here</a>.</p>
</div>

<?php include '../includes/footer.php'; ?>