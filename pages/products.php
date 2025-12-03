<?php
// pages/products.php
include '../includes/header.php';
include '../includes/db.php';

// Fetch products
$sql = "SELECT p.product_id, p.name, p.description, p.price, c.category_name, p.stock_quantity, p.image_path 
        FROM products p 
        JOIN categories c ON p.category_id = c.category_id
        ORDER BY p.product_id DESC";
$result = $conn->query($sql);
?>

<link rel="stylesheet" href="../css/products.css">
<link rel="stylesheet" href="../css/lightbox.css">

<div class="products-container">
    <div class="page-header">
        <h2>Our Products</h2>
        <p>Explore our premium collection of electronics. Click an image to zoom.</p>
    </div>

    <div class="product-grid">
        <?php
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $img = !empty($row['image_path']) ? "../image/" . $row['image_path'] : "../image/placeholder.jpg";
                $stock = $row['stock_quantity'];
                $isOutOfStock = ($stock <= 0);

                echo '
                <div class="product-card">
                    <div class="product-image-wrapper">
                        <span class="badge badge-category">'.$row['category_name'].'</span>
                        '.($isOutOfStock ? '<span class="badge badge-out">Sold Out</span>' : '').'
                        
                        <img src="'.$img.'" 
                             alt="'.htmlspecialchars($row['name']).'" 
                             class="lightbox-trigger" 
                             style="cursor: pointer;"
                             title="Click to zoom">
                    </div>
                    
                    <div class="product-details">
                        <h3 class="product-title">'.htmlspecialchars($row['name']).'</h3>
                        <p class="product-desc">'.htmlspecialchars($row['description']).'</p>
                        
                        <div class="product-meta">
                            <span class="price">$'.number_format($row['price'], 2).'</span>
                            <span class="stock-status">'.($stock > 0 ? $stock.' in stock' : 'Unavailable').'</span>
                        </div>

                        <form method="post" action="cart.php">
                            <input type="hidden" name="product_id" value="'.$row['product_id'].'">
                            ';
                            
                            if (!$isOutOfStock) {
                                echo '<button type="submit" name="add_to_cart" class="btn-add">
                                        🛒 Add to Cart
                                      </button>';
                            } else {
                                echo '<button type="button" class="btn-add btn-disabled" disabled>
                                        Out of Stock
                                      </button>';
                            }
                            
                echo '  </form>
                    </div>
                </div>';
            }
        } else {
            echo '<p style="grid-column: 1/-1; text-align: center;">No products found in the inventory.</p>';
        }
        ?>
    </div>
</div>

<div id="myLightboxModal" class="lightbox-modal">
  <span class="close-lightbox">&times;</span>
  <img class="lightbox-content" id="img01">
  <div id="caption"></div>
</div>

<script src="../script/lightbox.js" defer></script>

<?php include '../includes/footer.php'; ?>