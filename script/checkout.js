// script/checkout.js

document.addEventListener("DOMContentLoaded", function () {
    const paymentSelect = document.getElementById("payment_method");
    const financingDiv = document.getElementById("financing-section");
    const planSelect = document.getElementById("financing_plan");
    
    const totalDisplay = document.getElementById("final-total");
    const financingInfoDisplay = document.getElementById("financing-info");
    
    // Get the original base total from the data attribute I added in PHP
    const baseTotal = parseFloat(totalDisplay.getAttribute("data-base-total"));

    function updateTotals() {
        const paymentMethod = paymentSelect.value;
        
        if (paymentMethod === "Financing") {
            // Show financing options
            financingDiv.style.display = "block";
            planSelect.required = true; // Make it required

            // Calculate Interest
            const months = parseInt(planSelect.value);
            let interestRate = 0;

            if (months === 12) interestRate = 0.05; // 5%
            if (months === 24) interestRate = 0.10; // 10%
            
            // Math
            const totalWithInterest = baseTotal * (1 + interestRate);
            const monthlyPayment = totalWithInterest / months;

            // Update UI
            totalDisplay.innerText = "$" + totalWithInterest.toFixed(2);
            financingInfoDisplay.innerText = `(${months} payments of $${monthlyPayment.toFixed(2)}/mo)`;
            
        } else {
            // Hide financing options
            financingDiv.style.display = "none";
            planSelect.required = false;

            // Reset UI to base total
            totalDisplay.innerText = "$" + baseTotal.toFixed(2);
            financingInfoDisplay.innerText = "";
        }
    }

    // Listen for changes
    paymentSelect.addEventListener("change", updateTotals);
    planSelect.addEventListener("change", updateTotals);
});