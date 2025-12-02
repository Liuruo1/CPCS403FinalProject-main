<?php
// pages/products.php
include '../includes/header.php';
include '../includes/db.php'; // We need the DB connection here

// Fetch data from the database
$sql = "SELECT p.name, p.description, p.price, c.category_name, p.stock_quantity 
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
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["category_name"] . "</td>";
                        echo "<td>" . $row["description"] . "</td>";
                        echo "<td>$" . $row["price"] . "</td>";
                        
                        // Simple logic to show "Out of Stock" if 0
                        if($row["stock_quantity"] > 0) {
                            echo "<td>" . $row["stock_quantity"] . "</td>";
                        } else {
                            echo "<td style='color:red;'>Out of Stock</td>";
                        }
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No products found</td></tr>";
                }
                ?>
                <tr>
                    <td colspan="4" style="text-align: right; font-weight: bold;">Total Items Listed:</td>
                    <td><?php echo $result->num_rows; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <br>
    <button onclick="window.print()">Print Product List</button>
</div>

<style>
    .product-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    .product-table th, .product-table td { border: 1px solid #ddd; padding: 12px; text-align: left; }
    .product-table th { background-color: #333; color: white; }
    .product-table tr:nth-child(even) { background-color: #f2f2f2; }
</style>

<?php
include '../includes/footer.php';
?>