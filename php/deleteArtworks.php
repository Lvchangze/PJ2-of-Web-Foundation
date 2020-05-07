<?php session_start();
include 'linkdb.php';
$artworkID = '';
if (isset($_POST['artworkID'])){
    $artworkID = $_POST['artworkID'];
}
mysqli_query($conn,"DELETE FROM artworks WHERE artworkID = '$artworkID'");
echo "<script>alert('删除成功');location.href='../personalInformation.php';</script>";
?>
