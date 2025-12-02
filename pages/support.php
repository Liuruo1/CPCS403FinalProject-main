<?php
// pages/support.php
include '../includes/header.php';
// include '../includes/db.php'; // UNCOMMENT THIS when database is ready

$message = "";

// --- PHP FORM HANDLING (Will run when you submit the form) ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Capture data
    $name = $_POST['fullname'];
    $email = $_POST['email'];
    $device = $_POST['device_type'];
    $issue = $_POST['issue_type']; // Radio button
    $details = $_POST['details'];
    
    // Checkboxes (need special handling if unchecked)
    $priority = isset($_POST['priority']) ? "Urgent" : "Normal";
    $callback = isset($_POST['callback']) ? "Yes" : "No";

    /* // --- DATABASE LOGIC (Keep commented until DB is created) ---
    // Requirement: Check if email already exists [cite: 96-98]
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
    $message = "<div class='success-msg'>Form logic works! (Database currently disabled)</div>";
}
?>

<div class="form-container">
    <h2>Technical Support Request</h2>
    <p>Please fill out the form below. All fields marked with * are mandatory.</p>

    <?php echo $message; ?>

    <form name="supportForm" action="support.php" method="POST" onsubmit="return validateForm()">
        
        <fieldset>
            <legend>Customer Information</legend>
            
            <div class="form-group">
                <label for="fullname">Full Name: *</label>
                <input type="text" id="fullname" name="fullname">
            </div>

            <div class="form-group">
                <label for="email">Email Address: *</label>
                <input type="text" id="email" name="email">
            </div>

            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone">
            </div>

            <div class="form-group">
                <label for="serial">Device Serial Number:</label>
                <input type="text" id="serial" name="serial">
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
                <label>Warranty Status: *</label><br>
                <input type="radio" id="under_warranty" name="issue_type" value="Warranty">
                <label for="under_warranty">Under Warranty</label>
                
                <input type="radio" id="expired" name="issue_type" value="Expired">
                <label for="expired">Warranty Expired</label>
            </div>

            <div class="form-group">
                <label>Preferences:</label><br>
                <input type="checkbox" id="priority" name="priority" value="Urgent">
                <label for="priority">Mark as Urgent Priority</label>
                <br>
                <input type="checkbox" id="callback" name="callback" value="Yes">
                <label for="callback">Request Callback</label>
            </div>

            <div class="form-group">
                <label for="details">Describe the Problem: *</label>
                <textarea id="details" name="details" rows="5"></textarea>
            </div>
        </fieldset>

        <button type="submit" class="btn-submit">Submit Ticket</button>
    </form>
</div>

<script src="../script/validation.js"></script>

<style>
    /* Form Styles */
    .form-container { max-width: 600px; margin: 0 auto; }
    fieldset { border: 1px solid #ccc; padding: 20px; margin-bottom: 20px; background: white; }
    legend { font-weight: bold; font-size: 1.2em; color: #333; }
    .form-group { margin-bottom: 15px; }
    label { display: inline-block; margin-bottom: 5px; font-weight: bold; }
    input[type="text"], select, textarea { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
    .btn-submit { background-color: #28a745; color: white; padding: 10px 20px; border: none; cursor: pointer; font-size: 16px; }
    .btn-submit:hover { background-color: #218838; }
    .error-msg { color: red; background: #ffe6e6; padding: 10px; margin-bottom: 15px; border: 1px solid red; }
    .success-msg { color: green; background: #e6ffe6; padding: 10px; margin-bottom: 15px; border: 1px solid green; }
</style>

<?php
include '../includes/footer.php';
?>