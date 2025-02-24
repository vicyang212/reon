<!-- 資料庫連線 -->
<?php
require_once('Connections/dbset.php');
require_once("feedback.php");
//如果session沒有自動啟動，則手動命令session功能
(!isset($_SESSION)) ? session_start() : "";
require_once("php_lib.php");

if (isset($_GET['sPath'])) {
    $sPath = $_GET['sPath'] . ".php";
} else {
    $sPath = "login-index.php";
}
// 確認有無登入
if (isset($_SESSION['login'])) {
    header(sprintf("location:%s", $sPath));
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once("headfile.php") ?>

</head>

<body>
    <?php require_once("newnavbar.php") ?>
    <div class="outline">
        <div class="frame">
            <form action="" method="POST" class="form-signin" id="forml">
                <div class="logo">REON</div>
                <div class="title">會員登入 Log In</div>
                <div class="enterBox">電子信箱</div>
                <input type="email" class="enterInput" placeholder="E-mail" id="inputAccount" name="inputAccount" required>
                <div class="enterBox" class="enterInput">密碼</div>
                <input type="password" class="enterInput" placeholder="password" id="inputPassword" name="inputPassword" required>
                <button type="submit" class="btn-login">登 入</button>
                <!-- <div class="forget"><a href="#">忘記密碼</a></div> -->
                <div class="forget"><a href="register_nooption.php">還不是會員</a></div>
            </form>
        </div>
    </div>

    <?php require_once("footer.php") ?>
    <?php require_once("jsfile.php") ?>
    <script src="commlib.js"></script>
    <script>
        // 會員登入功能
        $(function() {
            $("#forml").submit(function() {
                const inputAccount = $("#inputAccount").val();
                const inputPassword = MD5($("#inputPassword").val());
                $.ajax({
                    url: 'auth_user.php',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        inputAccount: inputAccount,
                        inputPassword: inputPassword,
                    },
                    success: function(data) {
                        if (data.c == true) {
                            alert(data.m);
                            window.location.href = "<?php echo $sPath; ?>"
                        } else {
                            alert(data.m);
                        }
                    },
                    error: function(data) {
                        alert("系統目前無法連接到後台資料庫");
                    }
                });
            });
        });

    </script>
</body>

</html>