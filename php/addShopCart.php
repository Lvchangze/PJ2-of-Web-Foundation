<?php session_start();
include 'linkdb.php';
if ($_SESSION['admin'] === 'true'){
    if (isset($_SESSION['userID'])&& isset($_SESSION['artworkID'])){
        $userID = $_SESSION['userID'];
        $artworkID = $_SESSION['artworkID'];
        $add = mysqli_query($conn,"INSERT INTO carts (userID , artworkID) VALUE ('$userID','$artworkID')");
        echo "<script> alert('商品存在，加入成功！');location.href = '../shoppingCart.php'</script>";
    }
} else{
    echo  "<script> alert('您没有权限，请立即登陆！');location.href = '../logIn.php'</script>";
}
?>

