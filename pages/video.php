<?php
// pages/video.php
include '../includes/header.php';
?>

<link rel="stylesheet" href="../css/video.css">

<div class="video-container">
    <h2>Product Demos & Reviews</h2>
    <p>Watch our exclusive local coverage of the latest tech.</p>

    <div class="video-stack">
        
        <div class="video-card">
            <h3>Review: Alienware X15 Gaming Laptop Performance</h3>
            <div class="video-wrapper">
                <video controls>
                    <source src="../videos/video1.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <p>We test the limits of the new RTX 3080 setup.</p>
        </div>

        <div class="video-card">
            <h3>Review: The Best Headset</h3>
            <div class="video-wrapper">
                <iframe 
                    src="https://www.youtube.com/embed/6CsJZxfZsL0" 
                    title="YouTube video player" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen>
                </iframe>
            </div>
            <p>Best headset on the market right now.</p>
        </div>

    </div>
</div>

<?php
include '../includes/footer.php';
?>