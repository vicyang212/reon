<div id="product_list">

    <?php require_once("breadcrumb.php") ?>
    <!-- 首欄輪播？) -->
    <?php require_once("main_carousel.php") ?>

    <!-- 商品列表 -->   
    <div class="product-list-content">

        <!-- 建立產品列表自動帶入資料庫 -->
        <?php
        $maxRows_rs = 12; //設定每一頁的數量
        $pageNum_rs = 0; //起始頁從0開始
        if (isset($_GET['pageNum_rs'])) {
            $pageNum_rs = $_GET['pageNum_rs'];
        }
        $startRow_rs = $pageNum_rs * $maxRows_rs;

        if (isset($_GET['search_name'])) {
            $queryFirst = sprintf("SELECT * FROM product,product_img, class WHERE p_open=1 AND product_img.sort=1 AND product.p_id=product_img.p_id AND product.classid=class.classid AND product.p_name LIKE '%s' ORDER BY product.p_id DESC", '%' . $_GET['search_name'] . '%');
        }
        // 建立類別查詢
        else if (isset($_GET['classid'])) {
            // 利用類別抓資料
            if (isset($_GET['classid'])) {
                if ($_GET['classid'] <= 4 || $_GET['classid'] == 40) {
                    $queryFirst = sprintf("SELECT * FROM product, product_img WHERE p_open=1 AND product_img.sort=1 AND product.p_id=product_img.p_id AND product.lv1classid='%d' ORDER BY product.p_id DESC", $_GET['classid']);
                } else if (($_GET['classid'] >= 5 && $_GET['classid'] <= 16) || ($_GET['classid'] >= 41 && $_GET['classid'] <= 43)) {
                    $queryFirst = sprintf("SELECT * FROM product, product_img WHERE p_open=1 AND product_img.sort=1 AND product.p_id=product_img.p_id AND product.lv2classid='%d' ORDER BY product.p_id DESC", $_GET['classid']);
                } else {
                    $queryFirst = sprintf("SELECT * FROM product, product_img WHERE p_open=1 AND product_img.sort=1 AND product.p_id=product_img.p_id AND product.classid='%d' ORDER BY product.p_id DESC", $_GET['classid']);
                }
            }
        } else {
            // 列出產品查詢結果
            $queryFirst = "SELECT * FROM product 
                JOIN product_img ON product.p_id = product_img.p_id 
                WHERE p_open=1 AND product_img.sort=1 
                ORDER BY product.p_id DESC";
        }

        $query = sprintf("%s LIMIT %d,%d", $queryFirst, $startRow_rs, $maxRows_rs);
        $pList01 = $link->query($query);
        $i = 1;

        while ($pList01_Rows = $pList01->fetch()) {
            if ($i % 4 == 1) {
        ?>
                <div class="row product-row">
                <?php
            }
                ?>

                <div class="col-md-3 col-sm-6 col-6">
                    <a href="good.php?p_id=<?php echo $pList01_Rows['p_id'] ?>">
                        <div class="product-item">
                            <div class="product-card-img">
                                <img src="./images/<?php echo $pList01_Rows['img_file'];   ?>" alt="" class="p-img">
                            </div>
                            <div class="product-card-content">
                                <?php echo $pList01_Rows['p_name']; ?>
                            </div>
                            <div class="product-price">
                                $
                                <?php echo $pList01_Rows['p_price']; ?>
                            </div>
                        </div>
                    </a>
                </div>
                <?php if ($i % 4 == 0 || $i == $pList01->rowCount()) { ?>
                </div>
        <?php }
                $i++;
            }
        ?>
        <!-- 頁碼 -->
        <?php
        //  取得目前頁數
        if (isset($_GET['totalRows_rs'])) {
            $totalRows_rs = $_GET['totalRows_rs'];
        } else {
            $all_rs = $link->query($queryFirst);
            $totalRows_rs = $all_rs->rowCount();
        }
        $totalPages_rs = ceil($totalRows_rs / $maxRows_rs) - 1;
        // 呼叫分頁的功能函數
        $prev_rs = "&laquo;";
        $next_rs = "&raquo;";
        $separator = "|";
        $max_links = 20;
        $pages_rs = buildNavigation($pageNum_rs, $totalPages_rs, $prev_rs, $next_rs, $separator, $max_links, true, 3, "rs");
        ?>
        <!-- 頁碼本體 -->
        <nav aria-label="Page navigation example">
            <ul class="pagination pagination-sm justify-content-end">
                <?php echo $pages_rs[0] . $pages_rs[1] . $pages_rs[2]; ?>
            </ul>
        </nav>
    </div>

</div>