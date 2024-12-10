

function checkPassword(){

    let p1 = document.changePasswordForm.newPassword.value.trim();
    let p2 = document.changePasswordForm.CNewPassword.value.trim();

    if (!p1 || !p2) {
        alert('Both password fields are required.');
        return false;
    }


    if (p1.length < 8) {
        alert('Password must be at least 8 characters long.');
        return false;
    }
    
    const IS_MATCH = p1 === p2;
    console.log(IS_MATCH, p1, p2)

    if(!IS_MATCH) {
        alert("Password doesn't match Confirm password")
        return IS_MATCH;
    }


    // Check for at least one uppercase letter
    const hasUppercase = /[A-Z]/.test(p1);
    if (!hasUppercase) {
        alert('Password must include at least one uppercase letter.');
        return false;
    }


    // Check for at least one lowercase letter
    const hasLowercase = /[a-z]/.test(p1);
    if (!hasLowercase) {
        alert('Password must include at least one lowercase letter.');
        return false;
    }


    // Check for at least one digit
    const hasDigit = /\d/.test(p1);
    if (!hasDigit) {
        alert('Password must include at least one digit.');
        return false;
    }


    // Check for at least one special character
    const hasSpecialChar = /[^a-zA-Z0-9]/.test(p1); // Matches any character that is not a letter or digit
    if (!hasSpecialChar) {
        alert('Password must include at least one special character.');
        return false;
    }

    return true;

} 
