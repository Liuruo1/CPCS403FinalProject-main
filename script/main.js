// script/main.js

// Function to open the modal and display the clicked image
function openModal(element) {
    var modal = document.getElementById("imageModal");
    var modalImg = document.getElementById("fullImage");
    var captionText = document.getElementById("caption");

    modal.style.display = "block";
    modalImg.src = element.src; // Set the big image source to the thumbnail source
    captionText.innerHTML = element.alt; // Use the alt text as a caption
}

// Function to close the modal
function closeModal() {
    var modal = document.getElementById("imageModal");
    modal.style.display = "none";
}

// Close modal if user clicks outside the image
window.onclick = function(event) {
    var modal = document.getElementById("imageModal");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}