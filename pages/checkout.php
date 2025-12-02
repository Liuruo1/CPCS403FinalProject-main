<?php
// pages/checkout.php
session_start();
include '../includes/db.php';

// 1. Redirect if cart is empty
if (empty($_SESSION['cart'])) {
    header("Location: products.php");
    exit();
}

// 2. Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    // Optional: Store current page to redirect back after login
    header("Location: login.php?redirect=checkout");
    exit();
}

$message = "";

// 3. Handle Order Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $address = $_POST['address'];
    $payment = $_POST['payment_method'];
    $total = 0;

    // Calculate Total Again (Security: Don't trust hidden fields for total)
    $ids = implode(',', array_keys($_SESSION['cart']));
    $sql = "SELECT product_id, price, stock_quantity FROM products WHERE product_id IN ($ids)";
    $result = $conn->query($sql);
    
    // Store product data for processing
    $products_data = [];
    while ($row = $result->fetch_assoc()) {
        $products_data[$row['product_id']] = $row;
        $total += $row['price'] * $_SESSION['cart'][$row['product_id']];
    }

    // Start Transaction (Ensures order and stock updates happen together)
    $conn->begin_transaction();

    try {
        // A. Insert into orders table
        $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, shipping_address, payment_method) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("idss", $user_id, $total, $address, $payment);
        $stmt->execute();
        $order_id = $conn->insert_id;
        $stmt->close();

        // B. Insert items and Update Stock
        $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt_stock = $conn->prepare("UPDATE products SET stock_quantity = stock_quantity - ? WHERE product_id = ?");

        foreach ($_SESSION['cart'] as $pid => $qty) {
            $price = $products_data[$pid]['price'];
            
            // Check stock availability
            if ($products_data[$pid]['stock_quantity'] < $qty) {
                throw new Exception("Product ID $pid is out of stock.");
            }

            // Insert Order Item
            $stmt_item->bind_param("iiid", $order_id, $pid, $qty, $price);
            $stmt_item->execute();

            // Update Stock
            $stmt_stock->bind_param("ii", $qty, $pid);
            $stmt_stock->execute();
        }

        // C. Commit Transaction
        $conn->commit();
        
        // D. Clear Cart and Redirect
        unset($_SESSION['cart']);
        header("Location: order_confirmation.php?order=$order_id");
        exit();

    } catch (Exception $e) {
        $conn->rollback(); // Undo changes if something failed
        $message = "<div class='error-msg'>Order Failed: " . $e->getMessage() . "</div>";
    }
}

// Include Header (Output HTML after logic)
// Note: header.php also calls session_start(), but PHP usually handles this gracefully.
include '../includes/header.php';
?>

<div class="checkout-container" style="max-width: 800px; margin: 0 auto; padding: 20px;">
    <h2>Checkout</h2>
    <?php echo $message; ?>

    <div class="order-summary" style="background: white; padding: 20px; border: 1px solid #ddd; margin-bottom: 20px;">
        <h3>Order Summary</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <th style="text-align: left;">Product</th>
                <th style="text-align: right;">Qty</th>
                <th style="text-align: right;">Subtotal</th>
            </tr>
            <?php
            $display_total = 0;
            $ids = implode(',', array_keys($_SESSION['cart']));
            $result = $conn->query("SELECT product_id, name, price FROM products WHERE product_id IN ($ids)");
            
            while ($row = $result->fetch_assoc()) {
                $qty = $_SESSION['cart'][$row['product_id']];
                $sub = $row['price'] * $qty;
                $display_total += $sub;
                echo "<tr>
                        <td>" . htmlspecialchars($row['name']) . "</td>
                        <td style='text-align: right;'>$qty</td>
                        <td style='text-align: right;'>$" . number_format($sub, 2) . "</td>
                      </tr>";
            }
            ?>
            <tr style="border-top: 2px solid #333; font-weight: bold;">
                <td colspan="2">Total</td>
                <td style="text-align: right;">$<?php echo number_format($display_total, 2); ?></td>
            </tr>
        </table>
    </div>

    <form method="POST" action="checkout.php" class="form-container" style="max-width: 100%;">
        <h3>Shipping & Payment</h3>
        
        <div class="form-group">
            <label>Shipping Address:</label>
            <textarea name="address" required rows="3" style="width: 100%; padding: 10px;"></textarea>
        </div>

        <div class="form-group">
            <label>Payment Method:</label>
            <select name="payment_method" style="width: 100%; padding: 10px;">
                <option value="Credit Card">Credit Card</option>
                <option value="PayPal">PayPal</option>
                <option value="Cash on Delivery">Cash on Delivery</option>
            </select>
        </div>

        <button type="submit" class="btn-submit" style="width: 100%; font-size: 1.2em;">Place Order</button>
    </form>
</div>

<style>
    .error-msg { color: red; background: #ffe6e6; padding: 10px; margin-bottom: 15px; }
</style>

<?php include '../includes/footer.php'; ?>