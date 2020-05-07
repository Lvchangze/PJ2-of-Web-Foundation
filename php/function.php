<?php
function main_outputArts($row){
    echo '<figure style="float: left;margin-left: 110px">
       
        <img src="images/img/'.$row['imageFileName'].'" onclick="AJAX('.$row['artworkID'].')">
       
        <figcaption>
            <p class = "pictureTitle" style="font-weight: bolder;font-size:20px;margin-left: 0;margin-top:50px;width: 300px;;word-break:keep-all;">'.$row['title'] .' </p>
            <p class="pictureArtist"  style="width: 300px;;word-break:keep-all;">Artist:'.$row['artist'].'</p>
            <p style="margin-right: 0;width: 300px;word-break:keep-all;">
               '.$row['description'].'
            </p> 
            <p style="font-size: 30px;margin-top: 0">Heat: '.$row['view'].'</p>
            <p style="font-size: 30px;margin-top: 0">Year: '.$row['yearOfWork'].'</p>
            <a href="shoppingCart.php" class="price">
            <p class = "picturePrice" style=" font-size: 45px;font-weight: bold;width: 300px;word-break:keep-all; margin-left: 0;margin-top: 0">
                Price: $'.$row['price'].'
            </p>
            </a>
        </figcaption>
    </figure>';
}

function search_outputArts($row){
    echo <<<EOF
        <section class="section" style="width:650px;height:300px;">
        <figure>           
            <img src="images/img/{$row['imageFileName']}" class="img" >            
            <div class="DIV" style="float:right;text-align:right;">
                <p style="font-size: 18px;width: 400px;word-break:keep-all;font-weight: bolder;">
        {$row['title']}
                </p>
                <p>
                    By {$row['artist']}
                </p>
            </div>
        </figure>
        <table class="table" style="float: right;margin-top:0;">
            <tr>
                <td>
                     <input type="button" style="color:red" class="button" value="热度： {$row['view']}" onclick="AJAX({$row['artworkID']})">
                </td>
                <td>
                     <input type="button" style="color:red" class="button" value="价格：$ {$row['price']}" onclick="AJAX({$row['artworkID']})">
                </td>
            </tr>
        </table>
    </section>
EOF;
}

function cart_outputArts($row){
    echo '<section class="main">
    <table style="text-align: center;">
        <tr>
            <td rowspan="5">
                <img src="images/img/'.$row['artworkID'].'.jpg" style="width: 350px;height: 300px;border-radius: 20px">
            </td>
        </tr>
        <tr>
            <td >
                <a style="font-size: 30px" href="goodInformation.php"  onclick="AJAX('.$row['artworkID'].')">
                    Name:'.$row['title'].'
                </a>
            </td>
        </tr>
        <tr>
            <td >
                <h3>
                    By '.$row['artist'].'
                </h3>
            </td>
        </tr>
        <tr>
            <td>
                '.$row['description'].'
            </td>
        </tr>
        <tr>
            <td style="margin-top: 20px">
                <input type="button"  class="button" value="价格:$ '.$row['price'].'" 
                style="font-size: 15px;width: 100px;border-radius: 10px" onclick="AJAX('.$row['artworkID'].')">             
                <input type="button" class="button" value="删除"  style="font-size: 15px;width: 100px;border-radius: 10px" onclick=" jump('.$row['artworkID'].')">
        </tr>
    </table>               
</section>';
}


?>