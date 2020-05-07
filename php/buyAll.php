<?php session_start();
include 'linkdb.php';
$balance =0;
$orderID = 0;
$totalPrice = $_SESSION['totalPrice'];
$userID = $_SESSION['userID'];
$judgeBalance = mysqli_query($conn,"SELECT * FROM users WHERE userID = '$userID'");
while ($row = $judgeBalance ->fetch_assoc()){
    $balance = (int)($row['balance']);
}
if ($totalPrice > $balance){
    echo '<script>alert("余额不足，请立即充值！");location.href = "../charge.php"</script>';
}else{
    echo '<script>alert("商品信息未改变！")</script>';
    $balance = $balance - $totalPrice;
    mysqli_query($conn,"UPDATE users SET balance = '$balance' WHERE userID ='$userID'");//修改余额
    mysqli_query($conn,"INSERT INTO orders (ownerID,sum) VALUE ('$userID',$totalPrice)");//新建订单

    $order = mysqli_query($conn,"SELECT * FROM orders ORDER BY timeCreated DESC LIMIT 1");
    while ($row = $order->fetch_assoc()){
        $orderID = (int)($row['orderID']);//拿到新的orderID
    };

    $findID = mysqli_query($conn ,"SELECT * FROM carts WHERE userID ='$userID'");//得到所有的购物条目
    while ($row2 = $findID ->fetch_assoc()) {
        $artworkID = $row2['artworkID'];
        $artworks = mysqli_query($conn, "SELECT * FROM artworks WHERE artworkID ='$artworkID'");
        mysqli_query($conn,"UPDATE artworks SET orderID = '$orderID' WHERE artworkID = '$artworkID'");
    }

    mysqli_query($conn , "DELETE FROM carts WHERE userID = '$userID'");//删除购物车

    echo '<script>alert("下单成功！");location.href = "../personalInformation.php"</script>';
}
?>