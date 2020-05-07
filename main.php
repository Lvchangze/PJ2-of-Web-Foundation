<?php session_start();
if (!isset($_SESSION['admin'])) {
    $_SESSION['admin'] = 'false';
}
include 'php/linkdb.php';
include 'php/function.php';
require_once 'php/footprint.php';
$titleName = '首页';
pushHistory($titleName)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Art Store</title>
    <link rel="stylesheet" href="css/main.css" >
    <script src="jquery/jquery-3.4.1.min.js"></script>
    <script src="js/cookie.js"></script>
    <script src="js/function.js"></script>
</head>
<body onload="changeImage();change()">
<header>
    <img id="image" style="position: absolute;top: 1px;width: 1520px;height: 676px">
    <nav >
        <a href="main.php">首页</a>
        <a href="search.php">搜索</a>
        <a href="goodInformation.php">商品详情</a>
        <a href="shoppingCart.php">购物车</a>
        <a href="logIn.php" id="1"><?php if (!isset($_SESSION['userName'])) echo '登陆';?></a>
        <a href="register.php" id="2"><?php if (!isset($_SESSION['userName'])) echo '注册';?></a>
        <a href="personalInformation.php" id="3"><?php if (isset($_SESSION['userName'])) echo "登陆者：".$_SESSION['userName'];?></a>
        <a href="php/destroySession.php" id="4" ><?php if (isset($_SESSION['userName'])) echo '登出';?></a>
        <br>
        <p style="color: white;margin: 0">
            足迹：
            <?php
            printHistory();
            ?>
        </p>
    </nav>
    <a href="main.php" style="position: absolute;"><h1 class="h1">Art Store</h1></a>
    <p class="标语">Want it ? Buy it !</p>
    <p class="Learnmore">
        <a href="goodInformation.php">→Learn More←</a>
    </p>
</header>
<p class="引导">
    ↓  ↓  ↓ Popular  Artworks ↓  ↓  ↓
</p>
<br><br>
<section>
    <?php
    //最新发布的作品
    $showing = mysqli_query($conn,"SELECT * FROM artworks WHERE orderID is null ORDER BY timeReleased desc LIMIT 3") ;
    while ($row = $showing ->fetch_assoc()){
        main_outputArts($row);
    }
    ?>
</section>
<script>
    //轮播最热的图片
    const arr = [];
    <?php
    $index = 0;
    $result = mysqli_query($conn,"SELECT * FROM artworks WHERE orderID is null order by view  desc  limit 4 ");
    while($row = $result->fetch_assoc()){
        $src = '"images/img/'.$row['imageFileName'].'"';
        echo 'arr['.$index.']='.$src.';';
        $index ++;
    }
    ?>

    var i = 0;

    function changeImage(){
        const ima = document.getElementById("image");
        ima.src=arr[i];
        i++;
        if( i===4 )
            i=0;
        setTimeout("changeImage();stopdisappear();startappear();change()",2500)
    }

    var opacity = 1;

    function change() {
        setTimeout("startdisappear()",2000);
        setTimeout("stopappear()",3000)
    }

    function startdisappear() {
        opa = 1;
        s = setInterval("opacity -= 0.1;" +
            "document.getElementById(\"image\").style.opacity = opacity;",50)
    }

    function stopdisappear() {
        clearInterval(s);
        opa = 0;
    }

    function startappear() {
        opa = 0;
        t = setInterval("opacity += 0.1;" +
            "document.getElementById(\"image\").style.opacity = opacity;",50)
    }

    function stopappear() {
        clearInterval(t);
        document.getElementById("image").style.opacity = "1";
    }

    
</script>
</body>
</html>