<?php session_start();
include 'linkdb.php';
include 'function.php';
$currentPage = $_POST['currentPage'];
$totalCount = $_POST['totalCount'];
$totalPage =$_POST['totalPage'];
$pageSize = $_POST['pageSize'];
$search = $_POST['search'];//关键字
$orderCriteria = $_POST['orderCriteria'];//判断标准
$order = $_POST['order'];//升降序
$startCount = (int)($currentPage-1)* 6 + 1;

if ($orderCriteria === 'price' && $order === 'down') {
    $priceDown = mysqli_query($conn, "SELECT * FROM artworks  WHERE description REGEXP '$search' or title REGEXP '$search'or artist REGEXP '$search' and orderID is null ORDER BY price DESC limit " . $startCount . "," . $pageSize);
    while ($row = $priceDown->fetch_assoc()) {
        search_outputArts($row);
    }
}

if ($orderCriteria === 'heat' && $order === 'down'){
    $heatDown = mysqli_query($conn,"SELECT * FROM artworks  WHERE description REGEXP '$search' or title REGEXP '$search'or artist REGEXP '$search' and orderID is null ORDER BY view DESC limit " . $startCount . "," . $pageSize);
    while($row = $heatDown ->fetch_assoc()) {
        search_outputArts($row);
    }
}

if ($orderCriteria === 'heat' && $order === 'up'){
    $heatUp =  mysqli_query($conn,"SELECT * FROM artworks  WHERE description REGEXP '$search' or title REGEXP '$search'or artist REGEXP '$search' and orderID is null ORDER BY view limit " . $startCount . "," . $pageSize);
    while($row = $heatUp->fetch_assoc()) {
        search_outputArts($row);
    }
}

if ($orderCriteria === 'price' && $order === 'up'){
    $priceUp = mysqli_query($conn,"SELECT * FROM artworks  WHERE description REGEXP '$search' or title REGEXP '$search'or artist REGEXP '$search'  and orderID is null ORDER BY price limit " . $startCount . "," . $pageSize);
    while($row = $priceUp->fetch_assoc()) {
        search_outputArts($row);
    }
}

?>