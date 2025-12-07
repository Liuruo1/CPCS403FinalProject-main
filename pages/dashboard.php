<?php
// pages/dashboard.php
include '../includes/header.php';
include '../includes/db.php'; 

// SECURITY CHECK: If user is not logged in, kick them out
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<link rel="stylesheet" href="../css/dashboard.css">

<div class="dashboard-container">
    <h2>Member Dashboard</h2>
    
    <div class="welcome-box">
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
    <?php while ($row = $result->fetch_assoc()): 
        $oid = $row['order_id'];
        
        // 1. Fetch all items for this order first
        $item_sql = "SELECT p.name, oi.quantity 
                     FROM order_items oi 
                     JOIN products p ON oi.product_id = p.product_id 
                     WHERE oi.order_id = $oid";
        $items_result = $conn->query($item_sql);
        
        $order_items = [];
        if ($items_result) {
            while($item = $items_result->fetch_assoc()){
                $order_items[] = $item;
            }
        }
        
        // Calculate how many rows this order will take up
        $rowspan = count($order_items);
        if ($rowspan == 0) $rowspan = 1; // Safety fallback

        // 2. Loop through items to create the rows
        foreach ($order_items as $index => $item):
    ?>
        <tr>
            <?php if ($index === 0): ?>
                <td rowspan="<?php echo $rowspan; ?>" class="align-middle">
                    #<?php echo $row['order_id']; ?>
                </td>
                <td rowspan="<?php echo $rowspan; ?>" class="align-middle">
                    <?php echo date("M d, Y", strtotime($row['order_date'])); ?>
                </td>
            <?php endif; ?>

            <td>
                <strong><?php echo $item['quantity']; ?>x</strong> 
                <?php echo htmlspecialchars($item['name']); ?>
            </td>
            
            <?php if ($index === 0): ?>
                <td rowspan="<?php echo $rowspan; ?>" class="align-middle">
                    $<?php echo number_format($row['total_amount'], 2); ?>
                </td>
                <td rowspan="<?php echo $rowspan; ?>" class="align-middle">
                    <?php echo htmlspecialchars($row['payment_method']); ?>
                </td>
                <td rowspan="<?php echo $rowspan; ?>" class="align-middle">
                    <span class="badge-success">Completed</span>
                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
    
    <?php 
    // Fallback if an order exists but has no items 
    if (empty($order_items)): 
    ?>
        <tr>
            <td>#<?php echo $row['order_id']; ?></td>
            <td><?php echo date("M d, Y", strtotime($row['order_date'])); ?></td>
            <td><em>No Items Found</em></td>
            <td>$<?php echo number_format($row['total_amount'], 2); ?></td>
            <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
            <td><span class="badge-success">Empty</span></td>
        </tr>
    <?php endif; ?>

    <?php endwhile; ?>
</tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="empty-history">You haven't placed any orders yet. <a href="products.php">Start shopping!</a></p>
        <?php endif; 
        $stmt->close();
        ?>
    </div>

    <div class="dashboard-actions">
        <a href="logout.php" class="btn-logout-dash">Logout</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>