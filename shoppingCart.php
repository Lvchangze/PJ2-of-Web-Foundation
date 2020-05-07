<?php session_start();
require_once 'php/footprint.php';
$titleName = '购物车';
pushHistory($titleName);
include 'php/function.php';
include 'php/linkdb.php';
if ($_SESSION['admin'] === 'false'){
    echo "<script>alert('您没有权限，请立即登录！');location.href='logIn.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>购物车</title>
    <link rel="stylesheet" href="css/shoppingCart.css">
    <script src="jquery/jquery-3.4.1.min.js"></script>
    <script src="js/function.js"></script>
    <script src="js/deleteCart.js"></script>
</head>
<body>
<header>
    <nav style="top: 0">
        <a href="main.php">首页</a>
        <a href="search.php">搜索</a>
        <a href="goodInformation.php">商品详情</a>
        <a href="personalInformation.php">个人信息</a>
        <p style="color: white;margin: 0">
            足迹：
            <?php
            printHistory();
            ?>
        </p>
    </nav>
    <a href="main.php"><h1 class="h1">Art Store</h1></a>
</header>
<section>
    <h1 class="car">购物车</h1>
    <?php
    $totalPrice = 0;
    $artworkID ='';
    $userID = $_SESSION['userID'];
    $findID = mysqli_query($conn ,"SELECT * FROM carts WHERE userID ='$userID'");
    while ($row = $findID ->fetch_assoc()){
        $artworkID = $row['artworkID'];
        $artworks = mysqli_query($conn,"SELECT * FROM artworks WHERE artworkID ='$artworkID'");
        while ($row = $artworks ->fetch_assoc()){
            cart_outputArts($row);
            $totalPrice += $row['price'];
        }
    }
    ?>
    <p style="font-size: 50px;margin-top:0;margin-left: 600px">总金额：$<?php echo $totalPrice; $_SESSION['totalPrice']  = $totalPrice;?></p>
    <input type="button" style="width: 150px;height: 80px;font-size: 30px;margin-left: 700px;margin-top: 0" value="下单" onclick="buyAll()">
</section>
</body>
<script>
    function buyAll() {
        location.href ='php/buyAll.php'
    }
</script>
</html>