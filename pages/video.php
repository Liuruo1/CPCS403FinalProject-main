<?php
// pages/video.php
include '../includes/header.php';
?>

<div class="video-container" style="text-align: center;">
    <h2>Product Reviews</h2>
    <p>Watch our latest tech reviews.</p>

    <div class="video-wrapper">
        <h3>Local Review (MP4)</h3>
        <video width="640" height="360" controls>
            <source src="../videos/demo.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

    <hr>

    <div class="video-wrapper">
        <h3>YouTube Review</h3>
        <iframe width="640" height="360" 
                src="https://www.youtube.com/embed/ScMzIvxBSi4" 
                title="YouTube video player" 
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen>
        </iframe>
    </div>
</div>

<?php
include '../includes/footer.php';
?>