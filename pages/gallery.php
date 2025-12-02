<?php
// pages/gallery.php
include '../includes/header.php';
?>

<div class="gallery-container">
    <h2>Product Gallery</h2>
    <p>Click on any image to view it in full size.</p>

    <div class="gallery-grid">
        <img src="https://via.placeholder.com/300x200?text=Laptop" 
             alt="Gaming Laptop" 
             class="thumbnail" 
             onclick="openModal(this)">
             
        <img src="https://via.placeholder.com/300x200?text=Phone" 
             alt="Smartphone" 
             class="thumbnail" 
             onclick="openModal(this)">
             
        <img src="https://via.placeholder.com/300x200?text=Headphones" 
             alt="Wireless Headphones" 
             class="thumbnail" 
             onclick="openModal(this)">
             
        <img src="https://via.placeholder.com/300x200?text=Smartwatch" 
             alt="Smart Watch" 
             class="thumbnail" 
             onclick="openModal(this)">
    </div>

    <div id="imageModal" class="modal">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="fullImage">
        <div id="caption"></div>
    </div>
</div>

<script src="../script/main.js"></script>

<style>
    /* Basic Gallery Styles */
    .gallery-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        justify-content: center;
    }
    .thumbnail {
        width: 200px;
        cursor: pointer;
        transition: 0.3s;
        border-radius: 5px;
    }
    .thumbnail:hover {
        opacity: 0.7;
        transform: scale(1.05);
    }

    /* Modal Styles (Overlay) */
    .modal {
        display: none; /* Hidden by default */
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
</style>

<?php
include '../includes/footer.php';
?>