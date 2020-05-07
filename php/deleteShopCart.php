<?php session_start();
include "linkdb.php";
if (isset($_GET['artworkID'])){
    $userID = $_SESSION['userID'];
    $deleteID = $_GET['artworkID'];
    mysqli_query($conn,"DELETE FROM carts WHERE artworkID = '$deleteID'");
}
echo '<script>alert("删除成功！");location.href = "../shoppingCart.php"</script>'
?>
