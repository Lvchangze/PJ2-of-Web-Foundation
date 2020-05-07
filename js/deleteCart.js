function jump(Id) {
        $.get(
            'php/deleteShopCart.php',
            {artworkID: Id},
            function () {
                window.location.href = 'php/deleteShopCart.php'
            })
}