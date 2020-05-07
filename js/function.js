function AJAX(id){
    $.post(
        'php/manage.php',
        {artworkID : id},
        function () {
            window.location.href = 'goodInformation.php';
        })
}

function transportOrderID(id) {
    var r =confirm("确认删除？");
    if (r === true) {
        $.post(
            'php/deleteOrders.php',
            {orderID: id},
            function () {
                window.location.href = 'php/deleteOrders.php';
            })
    }
}

function deleteArtwork(id) {
    var r =confirm("确认删除？");
    if (r === true){
        $.post(
            'php/deleteArtworks.php',
            {artworkID : id},
            function () {
                window.location.href = 'php/deleteArtworks.php';
            })
    }
}
