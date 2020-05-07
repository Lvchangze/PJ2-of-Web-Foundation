<?php session_start();
require_once 'php/footprint.php';
$titleName = '充值';
pushHistory($titleName);
include 'php/linkdb.php';
if ($_SESSION['admin'] === 'false'){
    die("您没有权限，请立即<a href='logIn.php'>登陆</a>");
}
if (isset($_POST['charge'])){
    $money = $_POST['charge'];
    $userName = $_SESSION['userName'];
    $balance = "UPDATE users SET balance = balance + '$money' WHERE name = '$userName'";
    if ($money <= 0 || (!is_numeric($money)||strpos($money,".")!==false)){
        echo "<script>
                  alert('请输入正整数！');
                  location.href='charge.php';
              </script>";
    }else
        {
        $add = mysqli_query( $conn, $balance );
        if($add){
            echo '<script>alert("充值成功");location.href="personalInformation.php"</script>';
        }else{
            echo '<script>alert("充值失败");location.href="#"</script>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>充值</title>
    <link href="css/登陆注册充值.css" rel="stylesheet">
    <script src="js/cookie.js"></script>
</head>
<body>
<a href="personalInformation.php" class="a1">→返回个人信息</a>
<a href="main.php" class="a2">→返回首页</a>
<p style="color: white;margin: 0">
    足迹：
    <?php
    printHistory();
    ?>
</p>
<h1 style="margin-top: 65px">用户登陆</h1>
<form class="subform"  method="post" action="#">
    <p>
        <label for="充值" class="label">请输入充值金额</label>
        <input name="charge" type="text"  id="充值" placeholder="美元$" autocomplete="off">
    </p>
    <p>
        <input type="submit" value="充值">
    </p>
</form>
<script>
</script>
</body>
</html>