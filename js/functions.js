var regexpSQLInjection = '/[\\t\\r\\n]|(--[^\\r\\n]*)|(\\/\\*[\\w\\W]*?(?=\\*)\\*\\/)/gi';

function showSignIn() {
    window.location.assign("signin_page.html");
}

function showSignUp() {
    window.location.assign("signup_page.html");
}

function checkFormSignUp() {
    return checkName() && checkSurname() && checkUsername();
}

function checkName() {
    var name = document.getElementById('inputName');
    return name.matches(regexpSQLInjection);
}

function checkSurname() {
    var surname = document.getElementById('inputSurname');
    return surname.matches(regexpSQLInjection);
}

function checkUsername() {
    var username = document.getElementById('inputUser');
    return username.matches(regexpSQLInjection);
}