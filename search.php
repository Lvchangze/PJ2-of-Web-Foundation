<?php session_start();
require_once 'php/footprint.php';
$titleName = '搜索';
pushHistory($titleName);
include 'php/function.php';
include 'php/linkdb.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>搜索</title>
    <link rel="stylesheet" href="css/search.css">
    <script src="jquery/jquery-3.4.1.min.js"></script>
    <script src="js/function.js"></script>
    <style>
        .pageButton {
            margin-top: 20px;
            width: 100px;
            height: 50px;
        }
    </style>
</head>
<body>
<header>
    <nav style="top: 0;">
        <a href="main.php">首页</a>
        <a href="shoppingCart.php">购物车</a>
        <a href="goodInformation.php">商品详情</a>
        <a href="personalInformation.php">个人信息</a>
        <p style="color: white;margin: 0">
            足迹：
            <?php
            printHistory();
            ?>
        </p>
    </nav>
    <a href="main.php"><h1 class="h1">Art Store</h1></a>
</header>

<form action="#" class="submit" method="post">
    <select name="title" style="height: 20px">
        <option value = "0">Select Title</option>
        <?php
        $artworks = mysqli_query($conn,'SELECT * FROM artworks WHERE orderID is null');
        while($row = $artworks->fetch_assoc()) {
            echo '<option value= "' . $row['title'] . '">'.$row['title'].'</option>';
        }
        ?>
     </select>
    <br>or <br>

    <input type="text" name="search" placeholder="输入名称、简介、作者的关键字搜索" style="width: 412px;height: 20px"  autocomplete="off">
    <br>
    排序：
    <select name ="orderCriteria" style="width: 50px;height: 30px">
        <option value = "price">价格</option>
        <option value = "heat">热度</option>
    </select>
    <select name ="order" style="width: 50px;height: 30px">
        <option value = "down">倒序</option>
        <option value = "up">升序</option>
    </select>
    <br>
    <input type="submit" value="搜索" style="width: 100px;height: 50px;font-size: 25px;margin-left: 150px">
</form>

<section class="big" style="margin-top: 100px">
    <h1>搜索结果：</h1>
<div id="result"></div>
    <?php
    if (isset($_POST['title'])){//单个
        if ($_POST['title'] !== null){
            $title = $_POST['title'];
            $queryTitle = "SELECT * FROM artworks WHERE title = '$title'";
            $titles = mysqli_query($conn,$queryTitle);
            while($row = $titles ->fetch_assoc()) {
                search_outputArts($row);
            }
        }
    }
    ?>

    <?php
    $currentPage = 0;
    $totalCount = 0;
    $totalPage = 1;
    $pageSize = 6;
    $search = '';//关键字
    $orderCriteria = '';//判断标准
    $order = '';//升降序
    if (isset($_POST['search'])){//多个
        $search = $_POST['search'];
        $orderCriteria = $_POST['orderCriteria'];
        $order = $_POST['order'];
        if ($_POST['search'] != null) {

            if ($orderCriteria === 'price' && $order === 'down'){
                $priceDown =  mysqli_query($conn,"SELECT * FROM artworks  
                                                          WHERE description REGEXP '$search' or title REGEXP '$search'or artist REGEXP '$search' ORDER BY price DESC ");
                $totalCount = $priceDown -> num_rows;//搜索总数
                $totalPage = ceil($totalCount/$pageSize) ;//总页数
            }

            if ($orderCriteria === 'heat' && $order === 'down'){
                $heatDown = mysqli_query($conn,"SELECT * FROM artworks  WHERE description REGEXP '$search' or title REGEXP '$search'or artist REGEXP '$search' ORDER BY view DESC ");
                $totalCount = $heatDown -> num_rows;//搜索总数
                $totalPage = ceil($totalCount / $pageSize) ;//总页数
                if ($totalPage === 0){
                    $currentPage = 0;
                }
            }
            if ($orderCriteria === 'heat' && $order === 'up'){
                $heatUp =  mysqli_query($conn,"SELECT * FROM artworks  WHERE description REGEXP '$search' or title REGEXP '$search'or artist REGEXP '$search' ORDER BY view ");
                $totalCount = $heatUp -> num_rows;//搜索总数
                $totalPage = ceil($totalCount / $pageSize) ;//总页数
            }
            if ($orderCriteria === 'price' && $order === 'up'){
                $priceUp = mysqli_query($conn,"SELECT * FROM artworks  WHERE description REGEXP '$search' or title REGEXP '$search'or artist REGEXP '$search' ORDER BY price");
                $totalCount = $priceUp -> num_rows;//搜索总数
                $totalPage = ceil($totalCount / $pageSize) ;//总页数
            }
        }
    }
    ?>
</section>
<div style="margin-left: 38.1%">
    <button class="pageButton" id="firstPage">首页</button>
    <button class="pageButton" id="previousPage">上一页</button>
    <button class="pageButton" id="nextPage">下一页</button>
    <button class="pageButton" id="lastPage">尾页</button>
</div>
<p style="margin-left: 44%;font-size: 30px;margin-top: 0">当前第<span id="currentPage">0</span>页，共<?php echo $totalPage?>页</p>
</body>
<script>
    var currentPage = <?php echo $currentPage ?>;
    var totalCount = <?php echo $totalCount?>;
    var totalPage = <?php echo $totalPage?>;
    var pageSize =<?php echo $pageSize ?>;
    var search = '<?php echo $search ?>';
    var orderCriteria = '<?php echo $orderCriteria ?>';
    var order = '<?php echo $order ?>';

    $('#firstPage').click(function () {
        currentPage = 1;
        document.getElementById('currentPage').innerText = currentPage;
            post();
        // alert(currentPage);
    });


    $('#previousPage').click(function () {
        if (currentPage >= 2) {
            currentPage -= 1;
        }else {
            currentPage = 1;
        }
        document.getElementById('currentPage').innerText = currentPage;
        post();
        // alert(currentPage);
    });


    $('#nextPage').click(function () {
        if (currentPage ===  totalPage) {
            currentPage = totalPage;
        }else {
            currentPage += 1;
        }
        document.getElementById('currentPage').innerText = currentPage;
        post();
    });


    $('#lastPage').click(function () {
        currentPage = totalPage;
        document.getElementById('currentPage').innerText = currentPage;
        post();
    });

    function post() {
        $.post(
            'php/page.php',
            {
                currentPage : currentPage,
                totalCount : totalCount,
                totalPage : totalPage,
                pageSize : pageSize,
                search : search,
                orderCriteria : orderCriteria,
                order: order
            },
            function(result) {
                $("#result").html(result)
            }
        );
    }
</script>
</html>