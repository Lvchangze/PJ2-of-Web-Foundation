<?php
require_once 'php/footprint.php';
$titleName = '注册';
pushHistory($titleName);
include 'php/linkdb.php';
if (isset($_POST['name'])&& isset($_POST['password'])&& isset($_POST['tel'])&& isset($_POST['email'])&& isset($_POST['location'])){
    $name = $_POST['name'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $location = $_POST['location'];
    $insert = "INSERT INTO users ( name, email, password, tel, address) VALUES ( '$name','$email','$password','$tel','$location')";
    $newUser = mysqli_query( $conn, $insert);
    if(! $newUser ) {
        die('注册失败，用户名已存在！'.'重新<a href="register.php">注册</a>');
    }else{
        echo "<script> alert('注册成功！请登录');location.href = 'logIn.php'
              </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>注册</title>
    <link href="css/登陆注册充值.css" rel="stylesheet">
    <script src="js/cookie.js"></script>
</head>
<body>
<a href="main.php" class="a1">→返回首页</a>
<a href="logIn.php" class="a2">→登陆</a>
<p style="color: white;margin: 0">
    足迹：
    <?php
    printHistory();
    ?>
</p>
<h1 style="margin-top: 65px">用户注册</h1><big style="color: red;">(*为必填)</big>
<form class="subform"  method="post" action="#" onsubmit="validate()">
    <p>
        <label for="name" class="label">请输入用户名</label>
        <input name="name" type="text" id="name" placeholder="不得与已存在的用户名重复" required autocomplete="off" onblur="checkName(this.value)"
               onfocus="checkName(this.value)" oninput="checkName(this.value)" >
        <span id="nameError" style="color:red;">*</span>
    </p>
    <p>
        <label for="password" class="label">请输入密码</label>
        <input name="password" type="password" id="password" placeholder="至少为6位，不能为纯数字" required autocomplete="off" onblur="checkPassword(this.value)"
               onfocus="checkPassword(this.value)" oninput="checkPassword(this.value)" >
        <span id="passwordError" style="color:red;">*</span>
    </p>
    <p>
        <label for="confirm" class="label">请确认密码</label>
        <input name="confirm" type="password" id="confirm" placeholder="请重新输入密码" required autocomplete="off" onblur="checkConfirm(this.value)"
               onfocus="checkConfirm(this.value)" oninput="checkConfirm(this.value)" >
        <span id="confirmError" style="color:red;">*</span>
    </p>
    <p>
        <label for="tel" class="label">请输入电话号码</label>
        <input  name="tel" type="text" id="tel" placeholder="11位数字电话号码" required autocomplete="off" onblur="checkTel(this.value)"
               onfocus="checkTel(this.value)" oninput="checkTel(this.value)">
        <span id="telError" style="color:red;">*</span>
    </p>
    <p>
        <label for="email" class="label">请输入邮箱</label>
        <input name="email" type="text" id="email" placeholder="邮箱必须符合邮箱命名规则" required autocomplete="off" onblur="checkEmail(this.value)"
               onfocus="checkEmail(this.value)" oninput="checkEmail(this.value)" >
        <span id="emailError" style="color:red;">*</span>
    </p>
    <p>
        <label for="location" class="label">请输入地址</label>
        <input name="location" type="text" id="location" placeholder="请输入收货地址" required autocomplete="off" onblur ="checkLocation(this.value)"
               onfocus="checkLocation(this.value)" oninput="checkLocation(this.value)" >
        <span id="locationError" style="color:red;">*</span>
    </p>
    <p>
        <input type="submit" value="注册">
    </p>
</form>
<script src="js/register.js"></script>
<script>
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