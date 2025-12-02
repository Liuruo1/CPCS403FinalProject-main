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
        
        // 2. Verify Password (compare typed password with DB hash)
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

<div class="form-container">
    <h2>Login</h2>
    <?php echo $message; ?>
    
    <form action="login.php" method="POST">
        <div class="form-group">
            <label>Username:</label>
            <input type="text" name="username" required>
        </div>
        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" class="btn-submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a>.</p>
</div>

<style>
    .form-container { max-width: 400px; margin: 30px auto; padding: 20px; background: white; border: 1px solid #ccc; }
    .form-group { margin-bottom: 15px; }
    input { width: 100%; padding: 8px; margin-top: 5px; }
    .error-msg { color: red; background: #ffe6e6; padding: 10px; margin-bottom: 10px; }
</style>

<?php include '../includes/footer.php'; ?>