<?php
require_once 'php/footprint.php';
$titleName = '登陆';
pushHistory($titleName);
session_start();
include 'php/linkdb.php';
if (isset($_POST['name'])&& isset($_POST['password'])){
    $name = $_POST['name'];
    $password = $_POST['password'];
    $truePassword = '';
    $theUser = mysqli_query($conn,"SELECT * FROM users WHERE name = '$name'");
    if (mysqli_num_rows($theUser)=== 0){
        echo '<script>alert("您还未注册，请立即注册！");location.href="register.php"</script>';
    }else {
        while ($row = $theUser -> fetch_assoc()){//得到正确的密码
            $truePassword = $row['password'];
        }
        if ($password !== $truePassword){
            echo '<script>alert("密码错误！");location.href="login.php"</script>';
        }else if ($password === $truePassword){//登陆成功
            $_SESSION['admin'] = "true";
            $nowUser = mysqli_query($conn,"SELECT * FROM users WHERE name = '$name'");
            while ($row2 = $nowUser -> fetch_assoc()){
                $_SESSION['userID'] = $row2['userID'];
                $_SESSION['userName'] =$row2['name'];
                $_SESSION['userEmail'] =$row2['email'];
                $_SESSION['userTel'] =$row2['tel'];
                $_SESSION['userAddress'] =$row2['address'];
            }
            echo '<script>alert("登陆成功！");location.href = "main.php"</script>';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登陆</title>
    <link href="css/登陆注册充值.css" rel="stylesheet">
    <script src="js/cookie.js"></script>
</head>

<body>
<a href="main.php" class="a1">→返回首页</a>
<a href="register.php" class="a2">→注册</a>
<br>
<p style="color: white;margin: 0">
    足迹：
    <?php
    printHistory();
    ?>
</p>
<h1 style="margin-top: 65px">用户登陆</h1><big style="color: red;">(*为必填)</big>
<form class="subform"  method="post" action="#" id="subform" onsubmit="return validate()">
    <p>
        <label for="姓名" class="label">请输入用户名</label>
        <input name="name" type="text"  id="姓名" required autocomplete="off" onblur="checkName(this.value)"
               onfocus="checkName(this.value)" oninput="checkName(this.value)">
        <span style="color:red;" id="nameError">*</span>
    </p>
    <p>
        <label for="密码" class="label">请输入密码</label>
        <input name="password" type="password"  id="密码" required onblur="checkPassword(this.value)"
               onfocus="checkPassword(this.value)" oninput="checkPassword(this.value)">
        <span style="color:red;" id="passwordError">*</span>
    </p>
    <p>
        <input type="submit" id="submit" value="登陆" autocomplete="off">
    </p>
</form>
<script>
    nameError = document.getElementById("nameError");
    passwordError = document.getElementById("passwordError");

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


    function validate() {
        var a = Math.floor(Math.random()*8+1);//0-9的随机数
        var b = Math.floor(Math.random()*8+1);
        var c = Math.floor(Math.random()*8+1);
        var d = Math.floor(Math.random()*8+1);
        var number = a*1000 + b*100 + c*10 + d;
        var validate = prompt("请输入您看到的验证码！\n"+number);
        if ( validate != number) {
            alert("输入错误！");
            return false;
        }else if ( validate == number){
            alert("输入成功！");
            return true;
        }
    }
</script>
</body>
</html>