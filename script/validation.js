// script/validation.js

function validateForm() {
    // 1. Get values from the form
    // We use document.forms["FormName"]["InputName"].value
    var name = document.forms["supportForm"]["fullname"].value;
    var email = document.forms["supportForm"]["email"].value;
    var device = document.forms["supportForm"]["device_type"].value;
    var details = document.forms["supportForm"]["details"].value;
    var issueType = document.forms["supportForm"]["issue_type"].value;

    // 2. Check for Empty Fields
    if (name == "") {
        alert("Please enter your Full Name.");
        return false; // Stop submission
    }

    if (email == "") {
        alert("Please enter your Email Address.");
        return false;
    }

    // 3. Email Format Validation (Regex)
    // Checks for character@character.domain
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!emailPattern.test(email)) {
        alert("Please enter a valid Email Address.");
        return false;
    }

    if (device == "") {
        alert("Please select a Device Type.");
        return false;
    }

    // Radio buttons return "" if nothing is checked, so we check if the variable is empty
    if (issueType == "") {
        alert("Please select your Warranty Status.");
        return false;
    }

    if (details == "") {
        alert("Please describe the problem.");
        return false;
    }

    // If everything passes, allow submission
    return true; 
}