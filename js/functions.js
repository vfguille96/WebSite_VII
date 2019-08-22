var regexpSQLInjection = '/[\\t\\r\\n]|(--[^\\r\\n]*)|(\\/\\*[\\w\\W]*?(?=\\*)\\*\\/)/gi';

function showSignIn() {
    window.location.assign("signin_page.html");
}

function showSignUp() {
    window.location.assign("signup_page.html");
}

function checkFormSignUp() {
    hashPass();
    return checkName() && checkSurname() && checkUsername();
}

function hashPass() {
    var inputPass = this.document.getElementById('inputPassword');
    inputPass.value = sha256(inputPass.value);
}

function checkFormSignIn() {
    hashPass();
    return checkUsername() && checkPassword();
}

function checkName() {
    var name = document.getElementById('inputName');
    return !name.value.matches(regexpSQLInjection);
}

function checkSurname() {
    var surname = document.getElementById('inputSurname');
    return !surname.value.matches(regexpSQLInjection);
}

function checkUsername() {
    var username = document.getElementById('inputUser');
    return !username.value.matches(regexpSQLInjection);
}

function checkPassword() {
    var pass = document.getElementById('inputPassword');
    return !pass.value.matches(regexpSQLInjection);
}

async function sha256(message) {
    // encode as UTF-8
    const msgBuffer = new TextEncoder('utf-8').encode(message);

    // hash the message
    const hashBuffer = await crypto.subtle.digest('SHA-256', msgBuffer);

    // convert ArrayBuffer to Array
    const hashArray = Array.from(new Uint8Array(hashBuffer));

    // convert bytes to hex string
    const hashHex = hashArray.map(b => ('00' + b.toString(16)).slice(-2)).join('');
    return hashHex;
}

