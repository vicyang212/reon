<!-- 資料庫連線 -->
<?php
require_once('Connections/dbset.php');

//如果session沒有自動啟動，則手動命令session功能
(!isset($_SESSION)) ? session_start() : "";

require_once("php_lib.php");
if (isset($_GET['sPath'])) {
    $sPath = $_GET['sPath'] . ".php";
} else {
    $sPath = "login.php";
}
// 確認有無登入
if (!isset($_SESSION['login'])) {
    header(sprintf("location:%s", $sPath));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php require_once("headfile.php") ?>
</head>

<body>
    <?php require_once("newnavbar.php") ?>

    <section id="cart_content">
        <?php require_once("cart_content_noinfo.php") ?>
    </section>

    <?php require_once("footer.php") ?>
    <?php require_once("jsfile.php") ?>

    <script>
        //單筆取消功能
        function btn_confirmLink(message, url) {
            if (message == "" || url == "") {
                return false;
            }
            if (confirm(message)) {
                window.location = url;
            }
            return false;
        }

        // 變更數量
        $(".cart-list input").change(function() {
            var qty = $(this).val();
            const cartid = $(this).attr("cartid");
            if (qty <= 0 || qty >= 50) {
                alert("更改數量需大於0以上，以及小於50以下。");
                return false;
            }
            $.ajax({
                url: 'change_qty.php',
                type: 'post',
                data: {
                    cartid: cartid,
                    qty: qty,
                },
                success: function(data) {
                    if (data.c == true) {
                        //alert(data.m);
                        window.location.reload();
                    } else {
                        alert(data.m)
                    }
                },
                error: function(data) {
                    alert("系統目前無法連線後台資料庫");
                }
            })
        })

        $('#btn04').click(function() {
            let msg = "系統將進行結帳，請確認金額與收件人是否正確";
            if (!confirm(msg)) return false;
            var fullAddress=$("#fullAddress").text();
            $.ajax({
                url: 'addorder.php',
                type: 'post',
                dataType: 'json',
                data: {
                    addressid: fullAddress,
                },
                success: function(data) {
                    if (data.c == true) {
                        alert(data.m);
                        window.location.href = "index.php";
                    } else {
                        alert("Database reponse error：" + data.m);
                    }
                },
                error: function(data) {
                    alert("ajax request error");
                }
            });
        });
    </script>
</body>

</html>