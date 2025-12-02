// script/calculator.js

function calculatePayment() {
    // 1. Get User Input
    var price = parseFloat(document.getElementById("price").value);
    var months = parseInt(document.getElementById("months").value);
    
    // Validation: Ensure price is a number
    if (isNaN(price) || price <= 0) {
        document.getElementById("result").innerHTML = "Please enter a valid price.";
        document.getElementById("result").style.color = "red";
        return;
    }

    // 2. Calculate Interest based on selection
    var interestRate = 0;
    if (months === 12) {
        interestRate = 0.05; // 5%
    } else if (months === 24) {
        interestRate = 0.10; // 10%
    }

    // 3. Perform Calculation
    var totalAmount = price * (1 + interestRate);
    var monthlyPayment = totalAmount / months;

    // 4. Display Result
    document.getElementById("result").style.color = "green";
    document.getElementById("result").innerHTML = 
        "Monthly Payment: $" + monthlyPayment.toFixed(2);
}