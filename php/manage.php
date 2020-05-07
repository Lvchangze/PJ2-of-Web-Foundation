<?php session_start();
include "linkdb.php";
if (isset($_POST['artworkID'])){
    $_SESSION['artworkID'] = $_POST['artworkID'];
}
?>
