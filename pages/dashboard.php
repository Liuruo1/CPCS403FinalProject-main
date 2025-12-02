<?php
// pages/dashboard.php
include '../includes/header.php';
include '../includes/db.php'; // [ADDED] Connect to DB

// SECURITY CHECK: If user is not logged in, kick them out
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<div class="dashboard-container" style="max-width: 900px; margin: 0 auto; padding: 20px;">
    <h2>Member Dashboard</h2>
    
    <div class="welcome-box" style="background: #e2e6ea; padding: 20px; border-radius: 5px; margin-bottom: 30px;">
        <h3>Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h3>
        <p>Manage your account and view your order history below.</p>
    </div>

    <div class="orders-section">
        <h3>My Order History</h3>
        
        <?php
        // Fetch orders for this specific user
        $sql = "SELECT order_id, total_amount, payment_method, order_date, shipping_address 
                FROM orders 
                WHERE user_id = ? 
                ORDER BY order_date DESC";
                
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0): 
        ?>
            <div class="table-responsive">
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Payment</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td>#<?php echo $row['order_id']; ?></td>
                                <td><?php echo date("M d, Y", strtotime($row['order_date'])); ?></td>
                                
                                <td>
                                    <?php
                                    $oid = $row['order_id'];
                                    $item_sql = "SELECT p.name, oi.quantity 
                                                 FROM order_items oi 
                                                 JOIN products p ON oi.product_id = p.product_id 
                                                 WHERE oi.order_id = $oid";
                                    $items = $conn->query($item_sql);
                                    
                                    $item_list = [];
                                    while($item = $items->fetch_assoc()){
                                        $item_list[] = $item['quantity'] . "x " . $item['name'];
                                    }
                                    echo implode("<br>", $item_list);
                                    ?>
                                </td>
                                
                                <td>$<?php echo number_format($row['total_amount'], 2); ?></td>
                                <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
                                <td><span class="badge-success">Completed</span></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>You haven't placed any orders yet. <a href="products.php">Start shopping!</a></p>
        <?php endif; 
        $stmt->close();
        ?>
    </div>

    <br><br>
    <a href="logout.php" class="btn-logout" style="background: red; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;">Logout</a>
</div>

<style>
    /* Table Styles */
    .order-table { width: 100%; border-collapse: collapse; background: white; border: 1px solid #ddd; }
    .order-table th, .order-table td { border: 1px solid #ddd; padding: 12px; text-align: left; }
    .order-table th { background-color: #333; color: white; }
    .order-table tr:nth-child(even) { background-color: #f9f9f9; }
    
    /* Badge Style */
    .badge-success {
        background-color: #28a745;
        color: white;
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 0.85em;
    }
</style>

<?php include '../includes/footer.php'; ?>