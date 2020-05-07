<?php
$conn = mysqli_connect('localhost', 'root', 'Lvchangze1396749', 'art');
if(! $conn )
{
    die('Could not connect: '. mysqli_error($conn));
}
mysqli_query($conn , "set names utf8");
?>