<?php
// pages/products.php
include '../includes/header.php';
include '../includes/db.php';

// [CHANGE 1] Updated Query: Added 'p.image_path' to the list of columns we select
$sql = "SELECT p.product_id, p.name, p.description, p.price, c.category_name, p.stock_quantity, p.image_path 
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
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        
                        // [CHANGE 3] Display the Image
                        // Checks if image exists, otherwise shows a default placeholder text
                        $img = !empty($row['image_path']) ? "../image/" . $row['image_path'] : "../image/placeholder.jpg";
                        echo "<td><img src='$img' alt='Product Image' width='60' height='60' style='object-fit: cover; border-radius: 4px;'></td>";
                        
                        echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["category_name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
                        echo "<td>$" . htmlspecialchars($row["price"]) . "</td>";
                        
                        if($row["stock_quantity"] > 0) {
                            echo "<td>" . $row["stock_quantity"] . "</td>";
                            // Add to Cart Form
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
                    echo "<tr><td colspan='7'>No products found</td></tr>"; // Increased colspan to 7
                }
                ?>
                <tr>
                    <td colspan="6" style="text-align: right; font-weight: bold;">Total Items Listed:</td>
                    <td><?php echo $result->num_rows; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<style>
    .product-table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white;}
    .product-table th, .product-table td { border: 1px solid #ddd; padding: 12px; text-align: left; vertical-align: middle; }
    .product-table th { background-color: #333; color: white; }
    .product-table tr:nth-child(even) { background-color: #f9f9f9; }
    
    /* Button Style */
    .btn-add {
        background-color: #ff9800;
        color: white;
        border: none;
        padding: 8px 12px;
        cursor: pointer;
        border-radius: 4px;
        font-weight: bold;
    }
    .btn-add:hover { background-color: #e68900; }
</style>

<?php include '../includes/footer.php'; ?>