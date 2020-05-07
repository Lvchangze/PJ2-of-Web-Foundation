<?php session_start();
include 'php/function.php';
include 'php/linkdb.php';
require_once 'php/footprint.php';
$titleName = '商品详情';
pushHistory($titleName);
$title = $imageFileName = $artist =$description  = $yearOfWork =$genre  = $view  = $price= $width = $height='';
if (isset($_SESSION['artworkID'])) {
    $artworkID = $_SESSION['artworkID'];
    $artwork = mysqli_query($conn, "SELECT * FROM artworks WHERE artworkID = '$artworkID'");
    mysqli_query($conn,"UPDATE artworks SET view = view + 1  WHERE artworkID = '$artworkID'");
    while ($row = $artwork->fetch_assoc()) {
        $title = $row['title'];
        $imageFileName = $row['imageFileName'];
        $artist = $row['artist'];
        $description = $row['description'];
        $yearOfWork = $row['yearOfWork'];
        $genre = $row['genre'];
        $view = $row['view'];
        $price = $row['price'];
        $width = $row['width'];
        $height = $row['height'];
    }
}else{
    echo '<script>alert("您未选择商品！");window.history.back()</script>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>商品详情</title>
    <link rel="stylesheet" href="css/goodInformation.css" >
    <script src="js/cookie.js"></script>
</head>
<body>
<header>
    <nav style="top: 0">
        <a href="main.php">首页</a>
        <a href="search.php">搜索</a>
        <a href="shoppingCart.php">购物车</a>
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
    <p class="name"><?php echo $title;?><a href="search.php"><small style="font-weight: normal;font-size: 20px">By   <?php echo $artist?></small></a></p>
    <img src="images/img/<?php echo $imageFileName ?>">
</section>
<section class="section1">
    <p class=" p1" style="width: 800px;word-break:keep-all;">This is an amazing work which called <big style="font-weight: bolder"><?php echo $title;?></big>.
        <br><?php echo $description;?></p>
    <h1 style="font-size: 3em;color: black;margin-top: -10px;margin-left:160px;font-weight: lighter;font-family: fantasy,serif">Price: <?php echo $price?></h1>
    <h3 style="font-size: 3em;margin-top: -20px;font-weight: bolder;margin-left:120px;font-family: 'Lucida Console',serif"><a href="php/addShopCart.php">→加入购物车</a></h3>
    <table class="table2">
        <tr>
            <th colspan="2">
                Product Details
            </th>
        </tr>
        <tr>
            <td>
               Date
            </td>
            <td>
                <?php echo $yearOfWork?>
            </td>
        </tr>
        <tr>
            <td>
                Dimensions
            </td>
            <td>
                <?php echo $width?>cm×<?php echo $height?>cm
            </td>
        </tr>
        <tr>
            <td>
               Heat
            </td>
            <td>
                <?php echo $view?>
            </td>
        </tr>
        <tr>
            <td>
                Genre
            </td>
            <td>
                <?php echo $genre?>
            </td>
        </tr>
    </table>
</section>
</body>
</html>