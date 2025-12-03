<?php
// pages/about.php
include '../includes/header.php';
?>

<!-- Link to external About CSS -->
<link rel="stylesheet" href="../css/about.css">

<div class="about-container">
    <h2>About the Developer</h2>
    <p>This project was developed for CPCS 403. Below is one of the developer's professional resume.</p>

    <!-- Resume 1 -->
    <div class="resume-wrapper">
        <object data="../image/resume.pdf" type="application/pdf" width="100%" height="100%">
            <p>Your web browser doesn't have a PDF plugin. 
            You can adhere to the requirement by using a browser like Chrome or Edge.</p>
        </object>
    </div>

    <!-- Resume 2 -->
    <div class="resume-wrapper">
        <object data="../image/resume2.pdf" type="application/pdf" width="100%" height="100%">
            <p>Your web browser doesn't have a PDF plugin. 
            You can adhere to the requirement by using a browser like Chrome or Edge.</p>
        </object>
    </div>
</div>

<?php include '../includes/footer.php'; ?>