<?php
// pages/video.php
include '../includes/header.php';
?>

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
            <h3>Review: The Best Smartphone</h3>
            <div class="video-wrapper">
                <video controls>
                    <source src="../videos/video2.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <p>A first look at the titanium build and new camera features.</p>
        </div>

    </div>
</div>

<style>
    /* Main Container */
    .video-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
        text-align: center;
    }

    /* Vertical Stack Layout */
    .video-stack {
        display: flex;
        flex-direction: column; /* Forces vertical stacking */
        align-items: center;    /* Centers items horizontally */
        gap: 50px;              /* Space between the two videos */
        margin-top: 40px;
    }

    /* Individual Video Card - Made Bigger */
    .video-card {
        width: 100%;           /* Take up full available width... */
        max-width: 900px;      /* ...but stop at 900px (Large size) */
        background: white;
        padding: 25px;         /* More padding for a premium look */
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        text-align: left;      /* Keep text left-aligned for readability */
    }

    .video-card h3 {
        margin-bottom: 15px;
        color: #333;
        font-size: 1.5em;
    }

    /* Video Player Styling */
    .video-wrapper video {
        width: 100%;
        height: auto;
        border-radius: 6px;
        background: #000;
        margin-bottom: 15px;
        display: block;
    }
    
    .video-card p {
        font-size: 1.1em;
        color: #555;
    }
</style>

<?php
include '../includes/footer.php';
?>