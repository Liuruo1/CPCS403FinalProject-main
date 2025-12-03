<?php
// pages/register.php
include '../includes/header.php';
include '../includes/db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if ($pass !== $confirm) {
        $message = "<div class='error-msg'>Passwords do not match!</div>";
    } else {
        // 1. Check if user already exists
        $check = $conn->prepare("SELECT user_id FROM users WHERE username = ? OR email = ?");
        $check->bind_param("ss", $user, $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $message = "<div class='error-msg'>Username or Email already taken.</div>";
        } else {
            // 2. Hash the password (SECURITY REQUIREMENT)
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

            // 3. Insert into DB using Prepared Statements
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $user, $email, $hashed_password);

            if ($stmt->execute()) {
                $message = "<div class='success-msg'>Account created! <a href='login.php'>Login here</a>.</div>";
            } else {
                $message = "<div class='error-msg'>Error: " . $conn->error . "</div>";
            }
            $stmt->close();
        }
        $check->close();
    }
}
?>

<link rel="stylesheet" href="../css/register.css">

<div class="register-container">
    <h2>Create Account</h2>
    <?php echo $message; ?>
    
    <form action="register.php" method="POST" class="register-form">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required placeholder="Choose a username">
        </div>
        
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required placeholder="Enter your email">
        </div>
        
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required placeholder="Create a password">
        </div>
        
        <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required placeholder="Repeat your password">
        </div>
        
        <button type="submit" class="btn-submit">Register</button>
    </form>
    
    <p class="login-link">Already have an account? <a href="login.php">Login here</a>.</p>
</div>

<?php include '../includes/footer.php'; ?>