<?php
// pages/support.php
include '../includes/header.php';
// include '../includes/db.php'; // UNCOMMENT THIS when database is ready

$message = "";

// --- PHP FORM HANDLING ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Capture data
    $name = $_POST['fullname'];
    $email = $_POST['email'];
    $device = $_POST['device_type'];
    $issue = isset($_POST['issue_type']) ? $_POST['issue_type'] : '';
    $details = $_POST['details'];
    
    // Checkboxes
    $priority = isset($_POST['priority']) ? "Urgent" : "Normal";
    $callback = isset($_POST['callback']) ? "Yes" : "No";

    /* // --- DATABASE LOGIC (Keep commented until DB is created) ---
    // Requirement: Check if email already exists
    $check_sql = "SELECT * FROM support_tickets WHERE email = '$email'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        $message = "<div class='error-msg'>Error: A ticket for this email already exists.</div>";
    } else {
        // Insert new record
        $sql = "INSERT INTO support_tickets (full_name, email, device_type, issue_type, priority_level, message)
                VALUES ('$name', '$email', '$device', '$issue', '$priority', '$details')";
        
        if ($conn->query($sql) === TRUE) {
            $message = "<div class='success-msg'>Ticket submitted successfully!</div>";
        } else {
            $message = "<div class='error-msg'>Error: " . $conn->error . "</div>";
        }
    }
    */
    
    // Temporary message for testing visuals
    $message = "<div class='success-msg'>Ticket submitted successfully! (Database simulation)</div>";
}
?>

<link rel="stylesheet" href="../css/support.css">

<div class="support-container">
    <h2>Technical Support Request</h2>
    <p>Please fill out the form below. All fields marked with * are mandatory.</p>

    <?php echo $message; ?>

    <form name="supportForm" action="support.php" method="POST" onsubmit="return validateForm()">
        
        <fieldset>
            <legend>Customer Information</legend>
            
            <div class="form-group">
                <label for="fullname">Full Name: *</label>
                <input type="text" id="fullname" name="fullname" placeholder="Enter your full name">
            </div>

            <div class="form-group">
                <label for="email">Email Address: *</label>
                <input type="email" id="email" name="email" placeholder="Enter your email address">
            </div>

            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone" placeholder="Optional phone number">
            </div>

            <div class="form-group">
                <label for="serial">Device Serial Number:</label>
                <input type="text" id="serial" name="serial" placeholder="Found on the back of your device">
            </div>
        </fieldset>

        <fieldset>
            <legend>Issue Details</legend>

            <div class="form-group">
                <label for="device_type">Device Type: *</label>
                <select id="device_type" name="device_type">
                    <option value="">-- Select Device --</option>
                    <option value="Laptop">Laptop</option>
                    <option value="Smartphone">Smartphone</option>
                    <option value="Tablet">Tablet</option>
                    <option value="Accessory">Accessory</option>
                </select>
            </div>

            <div class="form-group">
                <label style="display:block; margin-bottom:8px;">Warranty Status: *</label>
                <input type="radio" id="under_warranty" name="issue_type" value="Warranty">
                <label for="under_warranty">Under Warranty</label>
                
                <input type="radio" id="expired" name="issue_type" value="Expired">
                <label for="expired">Warranty Expired</label>
            </div>

            <div class="form-group">
                <label style="display:block; margin-bottom:8px;">Preferences:</label>
                <input type="checkbox" id="priority" name="priority" value="Urgent">
                <label for="priority">Mark as Urgent Priority</label>
                <br>
                <input type="checkbox" id="callback" name="callback" value="Yes">
                <label for="callback">Request Callback</label>
            </div>

            <div class="form-group">
                <label for="details">Describe the Problem: *</label>
                <textarea id="details" name="details" rows="5" placeholder="Please describe the issue in detail..."></textarea>
            </div>
        </fieldset>

        <button type="submit" class="btn-submit">Submit Ticket</button>
    </form>
</div>

<script src="../script/validation.js"></script>

<?php
include '../includes/footer.php';
?>