<?php
// pages/calculator.php
include '../includes/header.php';
?>

<div class="calculator-container" style="max-width: 500px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
    <h2>Financing Calculator</h2>
    <p>Calculate your monthly payments for our electronics.</p>

    <div class="calc-form">
        <label>Product Price ($):</label>
        <input type="number" id="price" placeholder="e.g. 1200" style="width: 100%; padding: 10px; margin-bottom: 15px;">

        <label>Duration (Months):</label>
        <select id="months" style="width: 100%; padding: 10px; margin-bottom: 15px;">
            <option value="6">6 Months (0% Interest)</option>
            <option value="12">12 Months (5% Interest)</option>
            <option value="24">24 Months (10% Interest)</option>
        </select>

        <button onclick="calculatePayment()" style="width: 100%; padding: 10px; background: #333; color: white; cursor: pointer;">Calculate Payment</button>
    </div>

    <div id="result" style="margin-top: 20px; font-size: 1.2em; font-weight: bold; color: green;"></div>
</div>

<script src="../script/calculator.js"></script>

<?php include '../includes/footer.php'; ?>