<?php session_start();
include 'linkdb.php';
$orderID ='';
if (isset($_POST['orderID'])){
    $orderID = $_POST['orderID'];
}
mysqli_query($conn ,"DELETE FROM orders WHERE orderID ='$orderID'");

mysqli_query($conn,"UPDATE artworks SET orderID = NULL WHERE orderID = '$orderID'");
echo "<script>alert('删除成功');location.href='../personalInformation.php';</script>";
?>