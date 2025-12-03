<?php
// pages/gallery.php
include '../includes/header.php';
?>

<div class="gallery-container">
    <h2>Product Gallery</h2>
    <p>Click on any image to view it in full size.</p>

    <div class="gallery-grid">
        <img src="../image/laptop1.jpg" 
             alt="Alienware Gaming Laptop" 
             class="thumbnail" 
             onclick="openModal(this)">
             
        <img src="../image/phone1.jpg" 
             alt="iPhone 15 Pro Titanium" 
             class="thumbnail" 
             onclick="openModal(this)">
             
        <img src="../image/headphones.jpg" 
             alt="Sony Noise Cancelling" 
             class="thumbnail" 
             onclick="openModal(this)">
             
        <img src="../image/watch.jpg" 
             alt="Smart Watch Ultra" 
             class="thumbnail" 
             onclick="openModal(this)">

        <img src="../image/camera.jpg" 
             alt="Canon EOS R5" 
             class="thumbnail" 
             onclick="openModal(this)">
             
        <img src="../image/laptop2.jpg" 
             alt="MacBook Pro" 
             class="thumbnail" 
             onclick="openModal(this)">
             
        <img src="../image/laptop.jpg" 
             alt="Dell Inspiron 15" 
             class="thumbnail" 
             onclick="openModal(this)">

        <img src="../image/phone.jpg" 
             alt="Google Pixel 8" 
             class="thumbnail" 
             onclick="openModal(this)">

        <img src="../image/hub.jpg" 
             alt="USB-C Multi-port Hub" 
             class="thumbnail" 
             onclick="openModal(this)">

        <img src="../image/laptop3.jpg" 
             alt="HP Pavilion Laptop" 
             class="thumbnail" 
             onclick="openModal(this)">
    </div>

    <div id="imageModal" class="modal">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="fullImage">
        <div id="caption"></div>
    </div>
</div>

<script>
    function openModal(element) {
        var modal = document.getElementById("imageModal");
        var modalImg = document.getElementById("fullImage");
        var captionText = document.getElementById("caption");
        
        // This was likely causing the error because 'modal' was missing
        if (modal) {
            modal.style.display = "block";
            modalImg.src = element.src;
            captionText.innerHTML = element.alt;
        } else {
            console.error("Error: Modal element not found!");
        }
    }

    function closeModal() {
        document.getElementById("imageModal").style.display = "none";
    }

    // Close when clicking outside the image
    window.onclick = function(event) {
        var modal = document.getElementById("imageModal");
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

<style>
    /* Grid Layout */
    .gallery-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        justify-content: center;
        padding: 20px;
    }
    .thumbnail {
        width: 200px;
        height: 150px;
        object-fit: cover;
        cursor: pointer;
        transition: 0.3s;
        border-radius: 5px;
        border: 2px solid #ddd;
    }
    .thumbnail:hover {
        opacity: 0.7;
        transform: scale(1.05);
        border-color: #333;
    }

    /* Modal Styles */
    .modal {
        display: none; 
        position: fixed; 
        z-index: 1000; 
        padding-top: 100px; 
        left: 0;
        top: 0;
        width: 100%; 
        height: 100%; 
        overflow: auto; 
        background-color: rgba(0,0,0,0.9); 
    }
    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        animation-name: zoom;
        animation-duration: 0.6s;
    }
    #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }
    .close-btn {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
    }
    @keyframes zoom {
        from {transform:scale(0)} 
        to {transform:scale(1)}
    }
</style>

<?php
include '../includes/footer.php';
?>