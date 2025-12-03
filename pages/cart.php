<?php
// pages/cart.php
session_start(); // Start session manually to handle logic before HTML output
include '../includes/db.php';

// --- CART LOGIC ---

// 1. Add Item to Cart
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    
    // Initialize cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Increment quantity if already exists, otherwise set to 1
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]++;
    } else {
        $_SESSION['cart'][$product_id] = 1;
    }
    
    // Redirect back to products (or stay on cart)
    header("Location: cart.php");
    exit();
}

// 2. Remove Item
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $remove_id = $_GET['id'];
    unset($_SESSION['cart'][$remove_id]);
    header("Location: cart.php");
    exit();
}

// 3. Clear Cart
if (isset($_GET['action']) && $_GET['action'] == 'clear') {
    unset($_SESSION['cart']);
    header("Location: cart.php");
    exit();
}

// --- VIEW (HTML) ---
include '../includes/header.php';
?>

<link rel="stylesheet" href="../css/cart.css">

<div class="cart-container">
    <h2>Your Shopping Cart</h2>

    <?php if (empty($_SESSION['cart'])): ?>
        <p class="empty-cart-msg">Your cart is empty. <br><br> <a href="products.php">Go shopping!</a></p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="product-table"> 
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    // Get all keys (product IDs) from the cart array
                    $ids = implode(',', array_keys($_SESSION['cart']));
                    
                    // Fetch details for these products from DB
                    $sql = "SELECT product_id, name, price FROM products WHERE product_id IN ($ids)";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $id = $row['product_id'];
                            $qty = $_SESSION['cart'][$id];
                            $subtotal = $row['price'] * $qty;
                            $total += $subtotal;
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td>$<?php echo htmlspecialchars($row['price']); ?></td>
                                <td><?php echo $qty; ?></td>
                                <td>$<?php echo number_format($subtotal, 2); ?></td>
                                <td>
                                    <a href="cart.php?action=remove&id=<?php echo $id; ?>" class="btn-remove">Remove</a>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    <tr class="total-row">
                        <td colspan="3" style="text-align: right;">Grand Total:</td>
                        <td colspan="2">$<?php echo number_format($total, 2); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="cart-actions">
            <a href="cart.php?action=clear" class="btn-action btn-clear">Clear Cart</a>
            <a href="checkout.php" class="btn-action btn-checkout">Proceed to Checkout</a>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>