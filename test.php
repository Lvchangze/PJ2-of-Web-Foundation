<script src="jquery/jquery-3.4.1.min.js"></script>
<?php
?>
<script>
    function JUMP(id) {
        alert(id);
        $.get(
            'php/deleteShopCart.php',
            {deleteID : id},
            function () {
                alert(document.cookie['test']);
                // window.location.href = 'php/deleteShopCart.php';
            })
    //    }
</script>
