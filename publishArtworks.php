<?php session_start();
require_once 'php/footprint.php';
$titleName = '艺术品发布/修改';
pushHistory($titleName);
include "php/linkdb.php";
include "php/function.php";
if ($_SESSION['admin'] === 'false'){
    echo "<script>alert('您没有权限，请立即登录！');location.href='logIn.php';</script>";
}
?>
<?php
$ownerID = $_SESSION['userID'];
if (isset($_POST['title'])&& isset($_POST['artist'])&&isset($_POST['description'])
    &&isset($_POST['year'])&&isset($_POST['school'])&&isset($_POST['height'])&&isset($_POST['width'])&&isset($_POST['price'])) {
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $description = $_POST['description'];
    $year = $_POST['year'];
    $school = $_POST['school'];
    $height = $_POST['height'];
    $width = $_POST['width'];
    $price = $_POST['price'];
    $queryTitle = mysqli_query($conn,"SELECT * FROM artworks WHERE title = '$title'");
    if (mysqli_num_rows($queryTitle) !== 0){//找到了相同的图片
        $updateArtwork = mysqli_query($conn,"UPDATE artworks SET artist = '$artist',description = '$description',yearOfWork = '$year',gener = '$school',width = '$width',height = '$height'
                                            WHERE title = '$title'");
        echo '<script>alert("修改成功！");location.href ="personalInformation.php"</script>';
    }else if (mysqli_num_rows($queryTitle) === 0){//没有找到相同的图片
        $insertNewArtwork = mysqli_query($conn,"INSERT INTO artworks (title,artist,description,yearOfWork,genre,width,height,price,ownerID,imageFileName)
                                         VALUE ('$title','$artist','$description','$year','$school','$width','$height','$price','$ownerID','458.jpg')");
        echo '<script>alert("发布成功！");location.href ="personalInformation.php"</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>发布/修改艺术品</title>
    <link href="css/登陆注册充值.css" rel="stylesheet">
    <style>
    </style>
</head>
<script src="jquery/jquery-3.4.1.min.js"></script>
<script src="js/cookie.js"></script>
<body>
<a href="personalInformation.php" class="a1">→返回个人信息</a>
<p style="color: white;margin: 0">
    足迹：
    <?php
    printHistory();
    ?>
</p>
<h1 style="margin-top: 65px">发布/修改艺术品</h1><big style="color: red;">(*为必填)</big>
<form class="subform"  method="post" id="imgForm" onsubmit="validate()">
    <p>
        <label for="标题" class="label">请输入艺术品名称</label>
        <input name="title" type="text"  id="标题" required autocomplete="off" onblur="checkTitle(this.value)"
               onfocus="checkTitle(this.value)" oninput="checkTitle(this.value)" >
        <span style="color:red;" id="titleError">*</span>
    </p>
    <p>
        <label for="作者" class="label">请输入作者</label>
        <input name="artist" type="text"  id="作者" required onblur="checkArtist(this.value)"
               onfocus="checkArtist(this.value)" oninput="checkArtist(this.value)" autocomplete="off">
        <span style="color:red;" id="artistError">*</span>
    </p>
    <p>
        <label for="简介" class="label">请输入作品简介</label>
        <input name="description" type="text"  id="简介" required onblur="checkDescription(this.value)"
               onfocus="checkDescription(this.value)" oninput="checkDescription(this.value)" autocomplete="off">
        <span style="color:red;" id="descriptionError">*</span>
    </p>
    <p>
        <label for="年份" class="label">请输入作品年份</label>
        <input name="year" type="text"  id="年份" required onblur="checkYear(this.value)"
               onfocus="checkYear(this.value)" oninput="checkYear(this.value)" autocomplete="off">
        <span style="color:red;" id="yearError">*</span>
    </p>
    <p>
        <label for="流派" class="label">请输入作品流派</label>
        <input name="school" type="text"  id="流派" required onblur="checkSchool(this.value)"
               onfocus="checkSchool(this.value)" oninput="checkSchool(this.value)" autocomplete="off">
        <span style="color:red;" id="schoolError">*</span>
    </p>
    <p>
        <label for="高度" class="label">请输入作品高度</label>
        <input name="height" type="text"  id="高度" required onblur="checkHeight(this.value)"
               onfocus="checkHeight(this.value)" oninput="checkHeight(this.value)" autocomplete="off">
        <span style="color:red;" id="heightError">*</span>
    </p>
    <p>
        <label for="宽度" class="label">请输入作品宽度</label>
        <input name="width" type="text"  id="宽度" required onblur="checkWidth(this.value)"
               onfocus="checkWidth(this.value)" oninput="checkWidth(this.value)" autocomplete="off">
        <span style="color:red;" id="widthError">*</span>
    </p>
    <p>
        <label for="价格" class="label">请输入作品价格</label>
        <input name="price" type="text"  id="价格" required onblur="checkPrice(this.value)"
               onfocus="checkPrice(this.value)" oninput="checkPrice(this.value)" autocomplete="off">
        <span style="color:red;" id="priceError">*</span>
    </p>
    <p>
        <label for="图片" class="label">请选择图片</label>
        <input id="file" class="filepath" onchange="changepic(this)" type="file" required name="file" autocomplete="off">
        <span style="color:red;">*</span><br>
        <img src="" id="show" style="margin-left: 315px;width: 200px;height: 200px;display: none">
    </p>
    <p>
        <input type="submit" id="submit" name="submit" value="发布 / 修改" autocomplete="off">
    </p>
</form>
<script>
    titleError = document.getElementById("titleError");
    artistError = document.getElementById("artistError");
    descriptionError = document.getElementById('descriptionError');
    yearError = document.getElementById('yearError');
    schoolError = document.getElementById('schoolError');
    heightError = document.getElementById('heightError');
    widthError = document.getElementById('widthError');
    priceError = document.getElementById('priceError');

    function checkTitle(title){
        if(title === ""){
            titleError.innerHTML = "*不得为空"
        } else
            titleError.innerHTML = "*"
    }

    function checkArtist(artist){
        if(artist === ""){
            artistError.innerHTML = "*不得为空"
        } else
            artistError.innerHTML = "*"
    }

    function checkDescription(description){
        if(description === ""){
            descriptionError.innerHTML = "*不得为空"
        } else
            descriptionError.innerHTML = "*"
    }

    function checkYear(year){
        var ex = /^[0-9]+$/;
        if(year === ""){
            yearError.innerHTML = "*不得为空"
        } else if (!ex.test(year)){
            yearError.innerHTML = "*格式错误"
        }else {
            yearError.innerHTML = "*"
        }
    }

    function checkSchool(school){
        if( school === ""){
            schoolError.innerHTML = "*不得为空"
        } else
            schoolError.innerHTML = "*"
    }

    function checkHeight(height){
        if(height === ""){
            heightError.innerHTML = "*不得为空"
        } else if (height <= 0 || isNaN(height)){
            heightError.innerHTML = "*格式错误"
        }else {
            heightError.innerHTML = "*"
        }
    }

    function checkWidth(width){
        if(width === ""){
            widthError.innerHTML = "*不得为空"
        } else if (width <= 0 || isNaN(width)){
            widthError.innerHTML = "*格式错误"
        }else {
            widthError.innerHTML = "*"
        }
    }

    function checkPrice(price){
        var ex = /^[0-9]+$/;
        if(price === ""){
            priceError.innerHTML = "*不得为空"
        } else if (!ex.test(price)){
            priceError.innerHTML = "*格式错误"
        }else {
            priceError.innerHTML = "*"
        }
    }

    function changepic() {
        document.getElementById('show').style.display ="";
        var reads= new FileReader();
        f=document.getElementById('file').files[0];
        reads.readAsDataURL(f);
        reads.onload=function (e) {
            document.getElementById('show').src=this.result;
        };
    }

    function validate() {
        var a = Math.floor(Math.random()*8+1);//0-9的随机数
        var b = Math.floor(Math.random()*8+1);
        var c = Math.floor(Math.random()*8+1);
        var d = Math.floor(Math.random()*8+1);
        var number = a*1000 + b*100 + c*10 + d;
        var validate = prompt("请输入您看到的验证码！\n"+number);
        if ( validate != number) {
            alert("输入错误！");
            return false;
        }else if ( validate == number){
            alert("输入成功！");
            return true;
        }
    }


</script>
</body>
</html>
