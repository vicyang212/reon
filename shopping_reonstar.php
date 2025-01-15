<!-- 資料庫連線 -->
<?php
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

        <div id="product_list">
            <?php require_once("breadcrumb.php") ?>
            <?php require_once("main_carousel.php") ?>
            

            <!-- 商品列表 -->
            <div class="product-list-content">
                <div class="row">
                    <!-- 產品列表自動帶資料庫 -->
                    <?php
                    $queryStar = "SELECT * FROM reonstar, product, product_img WHERE product.p_open=1 AND product_img.sort=1 AND product.p_id = product_img.p_id AND product_img.p_id = reonstar.p_id ORDER BY reonstar.star_sort DESC";
                    $starList = $link->query($queryStar);
                    while ($starList_Row = $starList->fetch()) {
                    ?>

                        <div class="col-md-3 col-sm-6 col-6">
                            <a href="good.php?p_id=<?php echo $starList_Row['p_id'] ?>">
                                <div class="product-item">
                                    <div class="product-card-img"><img src="./images/<?php echo $starList_Row['img_file'];   ?>" alt="" class="p-img"></div>
                                    <div class="product-card-content">
                                        <?php echo $starList_Row['p_name']; ?>
                                    </div>
                                    <div class="product-price">
                                        $
                                        <?php echo $starList_Row['p_price']; ?>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>

    </section>


    <?php require_once("footer.php") ?>
    <?php require_once("jsfile.php") ?>


</body>

</html>