nameError = document.getElementById("nameError");
passwordError = document.getElementById("passwordError");
confirmError = document.getElementById("confirmError");
telError = document.getElementById("telError");
emailError = document.getElementById("emailError");
locationError = document.getElementById("locationError");

function checkName(name){  //验证name
    if(name === ""){
        nameError.innerHTML = "*不得为空"
    } else
        nameError.innerHTML = "*"
}

function checkPassword(password){
    const num =/^[-+]?\d*$/;
    if (password === ""){
        passwordError.innerHTML = "*不得为空";
    } else if (num.test(password)|| password.length <= 5) {
        passwordError.innerHTML = "*格式错误";
    } else
        passwordError.innerHTML = "*"
}

function checkConfirm(confirm) {
    if (confirm === "") {
        confirmError.innerHTML = "*不得为空"
    }else if (confirm !== document.getElementById("password").value){
        confirmError.innerHTML = "*与密码不符"
    }else
        confirmError.innerHTML = "*"
}

function checkTel(tel) {
    const num = /^\d{11}$/;
    if (tel === ""){
        telError.innerHTML = "*不得为空"
    } else if (!num.test(tel)){
        telError.innerHTML = "*格式错误"
    }else {
        telError.innerHTML = "*"
    }
}

function checkEmail(email) {
    const num = /^\w+@[a-zA-Z0-9]{2,10}(?:\.[a-z]{2,4}){1,3}$/;
    if(email === "")
        emailError.innerHTML = "*不得为空"
    else if (!num.test(email))
        emailError.innerHTML = "*格式错误"
    else
        emailError.innerHTML = "*"
}

function checkLocation(location) {
    if (location === "")
        locationError.innerHTML = "*不得为空"
    else
        locationError.innerHTML = "*"
}