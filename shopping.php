<!-- 資料庫連線 -->
<?php
require_once("feedback.php");
require_once('Connections/dbset.php');

//如果session沒有自動啟動，則手動命令session功能
(!isset($_SESSION)) ? session_start() : "";

require_once("php_lib.php");
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

    <section id="shopping_content">
            <!-- sidebar -->
            <?php require_once("sidebar.php") ?>

            <!-- product list -->
            <?php require_once("product_list.php") ?>
    </section>

    <?php require_once("footer.php") ?>
    <?php require_once("jsfile.php") ?>

</body>

</html>