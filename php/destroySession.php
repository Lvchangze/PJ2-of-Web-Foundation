<?php session_start();
unset($_SESSION['userName']);
unset($_SESSION['userID']);
unset($_SESSION['userEmail']);
unset($_SESSION['userTel']);
unset($_SESSION['userAddress']);
$_SESSION['admin'] = 'false';
echo "<script>alert('登出成功');location.href='../main.php';</script>";
?>
