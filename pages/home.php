<?php
// pages/home.php
include '../includes/header.php';
include '../includes/db.php'; // Required to fetch featured products
?>

<div class="hero-banner">
    <div class="hero-text">
        <h1>Welcome to ElectroTech</h1>
        <p>Discover the latest in high-performance electronics.</p>
        <a href="products.php" class="btn-hero">Shop Now</a>
    </div>
    <div class="hero-image">
        <img src="../image/laptop1.jpg" alt="Featured Laptop">
    </div>
</div>

<div class="home-container" style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    
    <div class="features-grid">
        <div class="feature-box">
            <h3>🚀 Fast Shipping</h3>
            <p>Get your gadgets delivered within 24 hours.</p>
        </div>
        <div class="feature-box">
            <h3>🛡️ 2-Year Warranty</h3>
            <p>All electronics come with full protection.</p>
        </div>
        <div class="feature-box">
            <h3>🎧 24/7 Support</h3>
            <p>Expert technicians ready to help you.</p>
        </div>
    </div>

    <hr style="margin: 40px 0; border: 0; border-top: 1px solid #ddd;">

    <div class="featured-products">
        <h2 style="text-align: center; margin-bottom: 20px;">Featured Products</h2>
        <div class="product-grid">
            <?php
            // Fetch 3 random products to display on home page
            $sql = "SELECT product_id, name, price, image_path FROM products ORDER BY RAND() LIMIT 3";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $img = !empty($row['image_path']) ? "../image/" . $row['image_path'] : "../image/placeholder.jpg";
                    echo '
                    <div class="product-card">
                        <img src="'.$img.'" alt="'.$row['name'].'">
                        <h4>'.$row['name'].'</h4>
                        <p class="price">$'.$row['price'].'</p>
                        <form method="post" action="cart.php">
                            <input type="hidden" name="product_id" value="'.$row['product_id'].'">
                            <button type="submit" name="add_to_cart" class="btn-add-small">Add to Cart</button>
                        </form>
                    </div>';
                }
            }
            ?>
        </div>
    </div>

    <div class="cta-section">
        <h3>Not sure what you need?</h3>
        <p>Check out our latest reviews or contact our support team.</p>
        <br>
        <a href="video.php" class="btn-secondary">Watch Reviews</a>
        <a href="support.php" class="btn-secondary">Contact Support</a>
    </div>
</div>

<style>
    /* Hero Section Styles */
    .hero-banner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #333;
        color: white;
        padding: 50px 10%;
        margin-bottom: 30px;
    }
    .hero-text h1 { font-size: 2.5em; margin-bottom: 10px; }
    .hero-text p { font-size: 1.2em; margin-bottom: 20px; }
    .btn-hero {
        background-color: #ff9800;
        color: white;
        padding: 12px 25px;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        font-size: 1.1em;
    }
    .btn-hero:hover { background-color: #e68900; }
    
    .hero-image img {
        max-width: 400px;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0,0,0,0.5);
    }

    /* Features Grid */
    .features-grid {
        display: flex;
        justify-content: space-around;
        text-align: center;
        flex-wrap: wrap;
        gap: 20px;
    }
    .feature-box {
        flex: 1;
        min-width: 250px;
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    /* Product Grid */
    .product-grid {
        display: flex;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap;
    }
    .product-card {
        background: white;
        border: 1px solid #eee;
        padding: 15px;
        border-radius: 8px;
        width: 250px;
        text-align: center;
        transition: transform 0.2s;
    }
    .product-card:hover { transform: translateY(-5px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
    .product-card img { width: 100%; height: 150px; object-fit: cover; border-radius: 5px; margin-bottom: 10px; }
    .product-card h4 { margin: 10px 0; font-size: 1.1em; }
    .product-card .price { color: #28a745; font-weight: bold; font-size: 1.2em; margin-bottom: 10px; }
    .btn-add-small {
        background-color: #333;
        color: white;
        border: none;
        padding: 8px 15px;
        cursor: pointer;
        border-radius: 4px;
        width: 100%;
    }
    .btn-add-small:hover { background-color: #555; }

    /* CTA Section */
    .cta-section {
        text-align: center;
        background-color: #f8f9fa;
        padding: 40px;
        margin-top: 40px;
        border-radius: 10px;
    }
    .btn-secondary {
        display: inline-block;
        border: 2px solid #333;
        color: #333;
        padding: 10px 20px;
        text-decoration: none;
        margin: 0 10px;
        border-radius: 5px;
        font-weight: bold;
    }
    .btn-secondary:hover { background-color: #333; color: white; }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-banner { flex-direction: column; text-align: center; }
        .hero-image { margin-top: 20px; }
        .hero-image img { max-width: 100%; }
    }
</style>

<?php
include '../includes/footer.php';
?>