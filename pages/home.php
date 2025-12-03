<?php
// pages/home.php
include '../includes/header.php';
include '../includes/db.php'; // Required to fetch featured products
?>

<link rel="stylesheet" href="../css/home.css">

<div class="hero-banner">
    <div class="hero-text">
        <span class="hero-subtitle">High-Performance Electronics</span>
        <h1>Welcome to <span class="highlight">ElectroTech</span></h1>
        <p>Upgrade your lifestyle with the latest gadgets and gear.</p>
        <div class="hero-buttons">
            <a href="products.php" class="btn-hero primary">Shop Now</a>
            <a href="about.php" class="btn-hero secondary">Learn More</a>
        </div>
    </div>
    <div class="hero-image">
        <img src="../image/laptop1.jpg" alt="Featured Laptop">
    </div>
</div>

<div class="home-container">
    
    <div class="features-grid">
        <div class="feature-box">
            <div class="icon">🚀</div>
            <h3>Fast Shipping</h3>
            <p>Get your gadgets delivered safely within 24 hours.</p>
        </div>
        <div class="feature-box">
            <div class="icon">🛡️</div>
            <h3>2-Year Warranty</h3>
            <p>Full protection plans included with every purchase.</p>
        </div>
        <div class="feature-box">
            <div class="icon">🎧</div>
            <h3>24/7 Support</h3>
            <p>Expert technicians ready to assist you anytime.</p>
        </div>
    </div>

    <div class="section-header">
        <h2>Featured Products</h2>
        <p>Check out our top picks for you</p>
    </div>

    <div class="product-grid">
        <?php
        // Fetch 3 random products to display on home page
        $sql = "SELECT product_id, name, price, image_path FROM products ORDER BY RAND() LIMIT 3";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $img = !empty($row['image_path']) ? "../image/" . $row['image_path'] : "../image/placeholder.jpg";
                echo '
                <div class="product-card">
                    <div class="card-image">
                        <img src="'.$img.'" alt="'.$row['name'].'">
                    </div>
                    <div class="card-details">
                        <h4>'.$row['name'].'</h4>
                        <p class="price">$'.$row['price'].'</p>
                        <form method="post" action="cart.php">
                            <input type="hidden" name="product_id" value="'.$row['product_id'].'">
                            <button type="submit" name="add_to_cart" class="btn-add-cart">Add to Cart</button>
                        </form>
                    </div>
                </div>';
            }
        } else {
            echo '<p style="text-align:center; width:100%;">No featured products available at the moment.</p>';
        }
        ?>
    </div>

    <div class="cta-section">
        <div class="cta-content">
            <h3>Not sure what you need?</h3>
            <p>Watch our detailed reviews or chat with our experts to find the perfect device.</p>
            <div class="cta-buttons">
                <a href="video.php" class="btn-outline">Watch Reviews</a>
                <a href="support.php" class="btn-outline">Contact Support</a>
            </div>
        </div>
    </div>
</div>

<?php
include '../includes/footer.php';
?>