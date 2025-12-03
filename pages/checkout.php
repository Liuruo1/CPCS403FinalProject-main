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
    header("Location: login.php?redirect=checkout");
    exit();
}

$message = "";

// 3. Handle Order Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    
    // Combine Address Fields into one string for storage
    $address = $_POST['address_street'] . ", " . 
               $_POST['address_city'] . ", " . 
               $_POST['address_state'] . " " . 
               $_POST['address_zip'] . ", " . 
               $_POST['address_country'];

    $payment = $_POST['payment_method'];
    
    // Calculate Base Total from DB (Security)
    $total = 0;
    $ids = implode(',', array_keys($_SESSION['cart']));
    $sql = "SELECT product_id, price, stock_quantity FROM products WHERE product_id IN ($ids)";
    $result = $conn->query($sql);
    
    $products_data = [];
    while ($row = $result->fetch_assoc()) {
        $products_data[$row['product_id']] = $row;
        $total += $row['price'] * $_SESSION['cart'][$row['product_id']];
    }

    // --- FINANCING LOGIC ---
    if ($payment == "Financing") {
        $months = (int)$_POST['financing_plan'];
        $interest_rate = 0;

        if ($months == 12) {
            $interest_rate = 0.05; // 5%
        } elseif ($months == 24) {
            $interest_rate = 0.10; // 10%
        }
        // 6 months remains 0%

        // Apply interest
        $total = $total * (1 + $interest_rate);
        
        // Update payment string for DB to include details
        $payment = "Financing ({$months} Months @ " . ($interest_rate * 100) . "%)";
    }

    // Start Transaction
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
            
            if ($products_data[$pid]['stock_quantity'] < $qty) {
                throw new Exception("Product ID $pid is out of stock.");
            }

            $stmt_item->bind_param("iiid", $order_id, $pid, $qty, $price);
            $stmt_item->execute();

            $stmt_stock->bind_param("ii", $qty, $pid);
            $stmt_stock->execute();
        }

        $conn->commit();
        unset($_SESSION['cart']);
        header("Location: order_confirmation.php?order=$order_id");
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        $message = "<div class='error-msg'>Order Failed: " . $e->getMessage() . "</div>";
    }
}

include '../includes/header.php';
?>

<link rel="stylesheet" href="../css/checkout.css">
<script src="../script/checkout.js" defer></script>

<div class="checkout-container">
    <h2>Checkout</h2>
    <?php echo $message; ?>

    <div class="order-summary">
        <h3>Order Summary</h3>
        <table class="summary-table">
            <thead>
                <tr>
                    <th style="text-align: left;">Product</th>
                    <th style="text-align: right;">Qty</th>
                    <th style="text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
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
                <tr class="total-row">
                    <td colspan="2">Total</td>
                    <td style="text-align: right;">
                        <span id="final-total" data-base-total="<?php echo $display_total; ?>">
                            $<?php echo number_format($display_total, 2); ?>
                        </span>
                        <small id="financing-info" class="financing-info"></small>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <form method="POST" action="checkout.php" class="form-section">
        <h3>Shipping Address</h3>
        
        <div class="address-grid">
            <div class="form-group full-width">
                <label for="address_street">Street Address:</label>
                <input type="text" id="address_street" name="address_street" required placeholder="1234 Main St, Apt 4B">
            </div>

            <div class="form-group">
                <label for="address_city">City:</label>
                <input type="text" id="address_city" name="address_city" required placeholder="New York">
            </div>

            <div class="form-group">
                <label for="address_state">State / Province:</label>
                <input type="text" id="address_state" name="address_state" required placeholder="NY">
            </div>

            <div class="form-group">
                <label for="address_zip">Zip / Postal Code:</label>
                <input type="text" id="address_zip" name="address_zip" required placeholder="10001">
            </div>

            <div class="form-group">
                <label for="address_country">Country:</label>
                <select id="address_country" name="address_country" required>
                    <option value="United States">United States</option>
                    <option value="Saudi Arabia">Saudi Arabia</option>
                    <option value="Canada">Canada</option>
                    <option value="United Kingdom">United Kingdom</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>

        <h3>Payment Method</h3>
        <div class="form-group">
            <select id="payment_method" name="payment_method">
                <option value="Credit Card">Credit Card</option>
                <option value="PayPal">PayPal</option>
                <option value="Cash on Delivery">Cash on Delivery</option>
                <option value="Financing">Financing (Monthly Payments)</option>
            </select>
        </div>

        <div id="financing-section" class="form-group financing-options">
            <label for="financing_plan">Choose a Plan:</label>
            <select id="financing_plan" name="financing_plan">
                <option value="6">6 Months (0% Interest)</option>
                <option value="12">12 Months (5% Interest)</option>
                <option value="24">24 Months (10% Interest)</option>
            </select>
            <p style="font-size: 0.85rem; color: #666; margin-top: 5px;">
                * Total amount will be adjusted based on the interest rate.
            </p>
        </div>

        <button type="submit" class="btn-submit">Place Order</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>