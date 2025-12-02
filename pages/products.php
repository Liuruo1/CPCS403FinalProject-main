<?php
// pages/products.php
include '../includes/header.php';
include '../includes/db.php';

// [CHANGE 1] Updated Query: Added 'p.product_id' so we can identify items
$sql = "SELECT p.product_id, p.name, p.description, p.price, c.category_name, p.stock_quantity 
        FROM products p 
        JOIN categories c ON p.category_id = c.category_id";
$result = $conn->query($sql);
?>

<div class="products-container">
    <h2>Our Products</h2>
    <p>Check out our latest inventory.</p>

    <div class="table-responsive">
        <table class="product-table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Action</th> </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["category_name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
                        echo "<td>$" . htmlspecialchars($row["price"]) . "</td>";
                        
                        if($row["stock_quantity"] > 0) {
                            echo "<td>" . $row["stock_quantity"] . "</td>";
                            // [CHANGE 3] Add to Cart Form
                            echo "<td>
                                    <form method='post' action='cart.php'>
                                        <input type='hidden' name='product_id' value='" . $row["product_id"] . "'>
                                        <button type='submit' name='add_to_cart' class='btn-add'>Add to Cart</button>
                                    </form>
                                  </td>";
                        } else {
                            echo "<td style='color:red;'>Out of Stock</td>";
                            echo "<td>-</td>";
                        }
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No products found</td></tr>";
                }
                ?>
                <tr>
                    <td colspan="5" style="text-align: right; font-weight: bold;">Total Items Listed:</td>
                    <td><?php echo $result->num_rows; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<style>
    .product-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    .product-table th, .product-table td { border: 1px solid #ddd; padding: 12px; text-align: left; }
    .product-table th { background-color: #333; color: white; }
    .product-table tr:nth-child(even) { background-color: #f2f2f2; }
    /* New Button Style */
    .btn-add {
        background-color: #ff9800;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        border-radius: 4px;
    }
    .btn-add:hover { background-color: #e68900; }
</style>

<?php include '../includes/footer.php'; ?>