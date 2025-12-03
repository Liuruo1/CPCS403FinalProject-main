<?php
// pages/about.php
include '../includes/header.php';
?>

<div class="about-container">
    <h2>About the Developer</h2>
    <p>This project was developed for CPCS 403. Below is one of the developer's professional resume.</p>

    <div class="resume-wrapper" style="border: 1px solid #ccc; margin-top: 20px; height: 900px;">
        <object data="../image/resume.pdf" type="application/pdf" width="100%" height="100%">
            <p>Your web browser doesn't have a PDF plugin. 
            You can adhere to the requirement by using a browser like Chrome or Edge.</p>
        </object>
    </div>
</div>

<?php include '../includes/footer.php'; ?>