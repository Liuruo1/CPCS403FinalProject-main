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

            // 3. Insert into DB using Prepared Statements (SQL INJECTION PREVENTION)
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

<div class="form-container">
    <h2>Create Account</h2>
    <?php echo $message; ?>
    
    <form action="register.php" method="POST">
        <div class="form-group">
            <label>Username:</label>
            <input type="text" name="username" required>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        <div class="form-group">
            <label>Confirm Password:</label>
            <input type="password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn-submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a>.</p>
</div>

<style>
    .form-container { max-width: 400px; margin: 30px auto; padding: 20px; background: white; border: 1px solid #ccc; }
    .form-group { margin-bottom: 15px; }
    input { width: 100%; padding: 8px; margin-top: 5px; }
    .error-msg { color: red; background: #ffe6e6; padding: 10px; margin-bottom: 10px; }
    .success-msg { color: green; background: #e6ffe6; padding: 10px; margin-bottom: 10px; }
</style>

<?php include '../includes/footer.php'; ?>