// script/lightbox.js

document.addEventListener("DOMContentLoaded", function () {
    // Get the modal
    var modal = document.getElementById("myLightboxModal");

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
    
    // Select all images with the class 'lightbox-trigger'
    var images = document.querySelectorAll(".lightbox-trigger");

    images.forEach(function(img) {
        img.addEventListener("click", function(){
            modal.style.display = "block";
            modalImg.src = this.src;
            // Use the alt text as the caption if available
            captionText.innerHTML = this.alt;
        });
    });

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close-lightbox")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // Also close if user clicks anywhere outside the image (on the background)
    modal.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }
});