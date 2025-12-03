<?php
// pages/order_confirmation.php
include '../includes/header.php';

if (!isset($_GET['order'])) {
    header("Location: home.php");
    exit();
}

$order_id = htmlspecialchars($_GET['order']);
?>

<link rel="stylesheet" href="../css/order_confirmation.css">

<div class="confirmation-container">
    <div class="success-icon">✓</div>
    <h1>Thank You!</h1>
    
    <p>Your order <span class="order-number">#<?php echo $order_id; ?></span> has been placed successfully.</p>
    <p>We will ship your items to the address provided shortly.</p>
    
    <a href="products.php" class="btn-continue">Continue Shopping</a>
</div>

<?php include '../includes/footer.php'; ?>