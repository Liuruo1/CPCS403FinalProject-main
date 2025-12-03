<?php
// pages/calculator.php
include '../includes/header.php';
?>

<link rel="stylesheet" href="../css/calculator.css">

<div class="calculator-container">
    <h2>Financing Calculator</h2>
    <p>Calculate your monthly payments for our electronics.</p>

    <div class="calc-form">
        <label for="price">Product Price ($):</label>
        <input type="number" id="price" placeholder="e.g. 1200" min="0">

        <label for="months">Duration (Months):</label>
        <select id="months">
            <option value="6">6 Months (0% Interest)</option>
            <option value="12">12 Months (5% Interest)</option>
            <option value="24">24 Months (10% Interest)</option>
        </select>

        <button onclick="calculatePayment()" class="btn-calculate">Calculate Payment</button>
    </div>

    <div id="result"></div>
</div>

<script src="../script/calculator.js"></script>

<?php include '../includes/footer.php'; ?>