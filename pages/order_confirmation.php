<?php
// pages/order_confirmation.php
include '../includes/header.php';

if (!isset($_GET['order'])) {
    header("Location: home.php");
    exit();
}

$order_id = htmlspecialchars($_GET['order']);
?>

<div style="text-align: center; padding: 50px;">
    <h1 style="color: green;">Thank You!</h1>
    <p>Your order (#<?php echo $order_id; ?>) has been placed successfully.</p>
    <p>We will ship your items to the address provided.</p>
    
    <br>
    <a href="products.php" class="btn-submit" style="text-decoration: none;">Continue Shopping</a>
</div>

<?php include '../includes/footer.php'; ?>