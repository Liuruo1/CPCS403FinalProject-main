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
// We include header AFTER logic to avoid "headers already sent" errors
// Note: includes/header.php also has session_start(), but PHP handles repeated calls gracefully usually, 
// or we can suppress the error. Ideally, header.php should check if session is started.
// For this project structure, we will just include it.
include '../includes/header.php';
?>

<div class="cart-container" style="max-width: 1000px; margin: 0 auto; padding: 20px;">
    <h2>Your Shopping Cart</h2>

    <?php if (empty($_SESSION['cart'])): ?>
        <p>Your cart is empty. <a href="products.php">Go shopping!</a></p>
    <?php else: ?>
        <table class="product-table"> <thead>
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

                if ($result->num_rows > 0) {
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
                                <a href="cart.php?action=remove&id=<?php echo $id; ?>" 
                                   style="color: red; text-decoration: none; font-weight: bold;">Remove</a>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
                <tr style="background-color: #333; color: white; font-weight: bold;">
                    <td colspan="3" style="text-align: right;">Grand Total:</td>
                    <td colspan="2">$<?php echo number_format($total, 2); ?></td>
                </tr>
            </tbody>
        </table>

        <div style="margin-top: 20px; text-align: right;">
            <a href="cart.php?action=clear" style="background: red; color: white; padding: 10px; text-decoration: none; border-radius: 4px;">Clear Cart</a>
            <a href="checkout.php" style="background: green; color: white; padding: 10px; text-decoration: none; border-radius: 4px; margin-left: 10px;">Proceed to Checkout</a>
        </div>
    <?php endif; ?>
</div>

<style>
    /* Reuse table styles */
    .product-table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
    .product-table th, .product-table td { border: 1px solid #ddd; padding: 12px; text-align: left; }
    .product-table th { background-color: #333; color: white; }
    .product-table tr:nth-child(even) { background-color: #f9f9f9; }
</style>

<?php include '../includes/footer.php'; ?>