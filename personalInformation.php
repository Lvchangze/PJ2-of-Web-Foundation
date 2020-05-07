<?php session_start();
require_once 'php/footprint.php';
$titleName = '个人信息';
pushHistory($titleName);
include 'php/linkdb.php';
include 'php/function.php';
if ($_SESSION['admin'] === 'false'){
    echo "<script>alert('您没有权限，请立即登录！');location.href='logIn.php';</script>";
}
$userID = $_SESSION['userID'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>个人信息</title>
    <link rel="stylesheet" href="css/personalInformation.css">
    <script src="js/cookie.js"></script>
    <style>
        .table1{
            border-spacing: 20px;
            font-size: 20px;
        }

        .table1 tr th {
            font-size: 30px;
        }

        span{
            font-weight: bold;
        }

        .table1 {
            border-radius: 10px;
            border:3px solid black;
        }

        .tables{
            border-spacing: 2px;
        }

        .tables td{
            /*width: 350px;*/
            border:1px solid black;
        }

        section section p{
            font-size: 30px;
            margin: 0;
            font-weight: bold
        }
    </style>
</head>
<script src="jquery/jquery-3.4.1.min.js"></script>
<script src="js/function.js"></script>
<body>
<header>
    <nav style="top: 0">
        <a href="main.php">首页</a>
        <a href="search.php">搜索</a>
        <a href="shoppingCart.php">购物车</a>
        <a href="goodInformation.php">商品详情</a>
        <a href="publishArtworks.php">发布/修改艺术品</a>
        <p style="color: white;margin: 0">
            足迹：
            <?php
            printHistory();
            ?>
        </p>
    </nav>
    <a href="main.php"><h1 class="h1">Art Store</h1></a>
</header>
<table class="table1" style="margin-top: 0;">
    <tr>
        <th colspan="2">
            个人信息
        </th>
    </tr>
    <tr>
        <td>
            <span>用户名 </span>  <?php
            if (isset($_SESSION['userName'])){
                echo $_SESSION['userName'];
            }
            ?>
        </td>
        <td>

        </td>
    </tr>
    <tr>
        <td>
            <span>邮箱 </span>  <?php
            if (isset($_SESSION['userEmail'])){
                echo $_SESSION['userEmail'];
            }
            ?>
        </td>
        <td>

        </td>
    </tr>
    <tr>
        <td>
            <span>地址 </span>  <?php
            if (isset($_SESSION['userAddress'])){
                echo $_SESSION['userAddress'];
            }
            ?>
        </td>
        <td>
        </td>
    </tr>
    <tr>
        <td>
            <span>电话 </span>  <?php
            if (isset($_SESSION['userTel'])){
                echo $_SESSION['userTel'];
            }
            ?>
        </td>
        <td>

        </td>
    </tr>
    <tr>
        <td>
            <span>余额 </span>  $<?php
            $name = $_SESSION['userName'];
            $nowUser = mysqli_query($conn,"SELECT * FROM users WHERE name = '$name'");
            while ($row = $nowUser ->fetch_assoc()){
                echo $row['balance'];
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>
        </td>
        <td>
            <form action="charge.php" method="post">
                <input id="charge" type="submit"  style="font-size: 25px;" value="→点我充值">
            </form>
        </td>
    </tr>
</table>
<section >
    <section >
        <p>我买入的艺术品：</p>
        <?php
        $buyIn = mysqli_query($conn, "SELECT * FROM orders WHERE ownerID ='$userID'");
        while ($row = $buyIn->fetch_assoc()) {
            echo '<table class="tables">
                <tr>
                    <td>订单编号:' . $row ["orderID"] . '</td>
                    <td>交易时间:' . $row ["timeCreated"] . '</td>                  
                    <td>交易总额：$ ' . $row ["sum"] . '</td>';
            $orderID = $row['orderID'];
            $artworkOrderID = mysqli_query($conn,"SELECT * FROM artworks WHERE orderID = '$orderID'");
             while($row2 = $artworkOrderID->fetch_assoc()) {
                 echo ' <td>商品名称:' . $row2 ["title"] . '</td>                  
                    <td onclick="AJAX('.$row2['artworkID'].')">详情</td>';
             }
             echo '<th><button class="delete" onclick="transportOrderID(' . $row['orderID'] . ')">删除</button></th>
                </tr>
            </table>';
        }
        ?>
    </section>

    <section >
        <p>我卖出的艺术品：</p>
        <?php
        $sellOut = mysqli_query($conn, "SELECT * FROM orders WHERE customerID ='$userID'");
        while ($row = $sellOut->fetch_assoc()) {
            echo '<table class="tables">
                <tr>
                    <td>订单编号:' . $row ["orderID"] . '</td>
                    <td>交易时间:' . $row ["timeCreated"] . '</td>                  
                    <td>交易总额：$ ' . $row ["sum"] . '</td>
                    <td>顾客ID：' . $row['ownerID'] . '</td>';
            $orderID = $row['orderID'];
            $artworkOrderID = mysqli_query($conn,"SELECT * FROM artworks WHERE orderID = '$orderID'");
            while($row2 = $artworkOrderID->fetch_assoc()) {
                echo ' <td>商品名称:' . $row2 ["title"] . '</td>                  
                    <td onclick="AJAX('.$row2['artworkID'].')">详情</td>';
            }
             echo   '<th><button class="delete" onclick="transportOrderID(' . $row['orderID'] . ')">删除</button></th>
                </tr>
            </table>';
        }
        ?>
    </section>
    <section >
        <p>我发布的艺术品：</p>
<!--        artworks表中的ownerID为我发布的-->
        <?php
        $myPublish = mysqli_query($conn , "SELECT * FROM artworks WHERE ownerID ='$userID'");
        while ($row = $myPublish->fetch_assoc()){
            echo '<table class="tables">
                <tr>
                    <td onclick="AJAX('.$row['artworkID'].')">艺术品名称:'.$row ["title"].'</td>
                    <td>发布时间:'.$row ["timeReleased"].'</td>                   
                    <th><button class=" update" >修改</button></th>
                    <th><button class="delete" onclick="deleteArtwork('.$row['artworkID'].')">删除</button></th>
                </tr>
            </table>';
        }
        ?>
    </section>
</section>
</body>
<script>
    $('.update').click(
        function () {
            location.href = "publishArtworks.php"
        }
    )
</script>
</html>