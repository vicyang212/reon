<!-- 資料庫連線 -->
<?php
require_once('Connections/dbset.php');
//如果session沒有自動啟動，則手動命令session功能
(!isset($_SESSION)) ? session_start() : "";
require_once("php_lib.php");

// 設定路徑
if (isset($_GET['sPath'])) {
    $sPath = $_GET['sPath'] . ".php";
} else {
    $sPath = "login.php";
}
// 沒有登入的話導回登入頁
if (!isset($_SESSION['login'])) {
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
    <div class="login-index-outline">
        <div class="page-title">
            <div class="location">
                <div class="location_item">親愛的會員，歡迎回來：</div>
            </div>
            <div class="btn btn-reon-logout"><a href="logout.php">登出</a></div>
        </div>
        <div class="login-item-content">
            <?php require_once("order-list-content.php") ?>
        </div>



        <?php
        $maxRows_rs = 5;
        $pageNum_rs = 0;
        if (isset($_GET['pageNum_order_rs'])) {
            $pageNum_rs = $_GET['pageNum_order_rs'];
        }
        $startRow_rs = $pageNum_rs * $maxRows_rs;
        $queryFirst = sprintf("SELECT uorder.orderid, uorder.create_date as orderTime, uorder.remark, ms1.msname as howpay, ms2.msname AS status, addbook. * FROM uorder, addbook, multiselect as ms1, multiselect AS ms2 WHERE ms2.msid=uorder.status AND ms1.msid=uorder.howpay AND uorder.emailid='%d' AND uorder.addressid=addbook.addressid ORDER BY uorder.create_date DESC", $_SESSION['emailid']);
        $query = sprintf("%s LIMIT %d, %d", $queryFirst, $startRow_rs, $maxRows_rs);
        $order_rs = $link->query($query);
        $i = 21; //控制第一筆訂單開啟

        ?>
        <div>
            <?php
            if ($order_rs->rowCount() != 0) { ?>
                <div class="accordion" id="accordion_order">
                    <?php
                    while ($data01 = $order_rs->fetch()) {
                    ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne<?php echo $i; ?>">
                                <a class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne<?php echo $i; ?>" aria-expanded="true" aria-controls="collapseOne<?php echo $i; ?>">
                                    <div class="table-responsive-md" style="width: 100%;">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <td width="10%">訂單編號</td>
                                                    <td width="20%">訂購時間</td>
                                                    <td width="15%">付款方式</td>
                                                    <td width="15%">訂單狀態</td>
                                                    <td width="10%">收件人</td>
                                                    <td width="20%">地址</td>
                                                    <td width="10%">備註</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><?php echo $data01['orderid'] ?></td>
                                                    <td><?php echo $data01['orderTime'] ?></td>
                                                    <td><?php echo $data01['howpay'] ?></td>
                                                    <td><?php echo $data01['status'] ?></td>
                                                    <td><?php echo $data01['cname'] ?></td>
                                                    <td><?php echo $data01['address'] ?></td>
                                                    <td><?php echo $data01['remark'] ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </a>
                            </h2>
                            <div id="collapseOne<?php echo $i; ?>" class="accordion-collapse collapse <?php echo ($i == 21) ? 'show' : ''; ?>" data-bs-parent="#accordion_order" aria-labelledby="headingOne<?php echo $i; ?>">
                                <div class="accordion-body">
                                    <?php
                                    $SQLstring = sprintf("SELECT *, ms1.msname as status FROM cart,product, product_img, multiselect as ms1 WHERE cart.orderid='%s' AND ms1.msid=cart.status AND cart.p_id=product_img.p_id AND product.p_id=product_img.p_id AND cart.p_id=product.p_id AND product_img.sort=1 ORDER BY cart.create_date DESC", $data01['orderid']);
                                    $cart_rs = $link->query($SQLstring);
                                    $cart_rs = $link->query($SQLstring);
                                    if ($cart_rs->rowCount() == 0) {
                                        echo "沒有找到對應的購物車資料";
                                    }
                                    $pTotal = 0;
                                    ?>
                                    <div class="table-responsive-md" style="width: 100%;">
                                        <table class="table table-hover mt-3">
                                            <thead>
                                                <tr class="text-bg-primary">
                                                    <td width="10%">圖片</td>
                                                    <td width="30%">名稱</td>
                                                    <td width="15%">數量</td>
                                                    <td width="15%">小計</td>
                                                    <td width="15%">狀態</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                while ($cart_data = $cart_rs->fetch()) {
                                                ?>
                                                    <tr>
                                                        <td><img src="./images/?php echo $cart_data['img_file']; ?>" alt="" class="img-fluid"></td>
                                                        <td><?php echo $cart_data['p_name']; ?></td>
                                                        <td><?php echo $cart_data['qty']; ?></td>
                                                        <td>
                                                            <h4 class="pt-1">$<?php echo $cart_data['p_price'] * $cart_data['qty']; ?></h4>
                                                        </td>
                                                        <td><?php echo $cart_data['status'] ?></td>
                                                    </tr>
                                                <?php
                                                    $pTotal += $cart_data['p_price'] * $cart_data['qty'];
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="7" style="text-align: center;">累計：$<?php echo $pTotal; ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7" style="text-align: center;">運費：$100</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7" style="text-align: center;">總計：$<?php echo $pTotal + 100; ?></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    <?php
                        $i++;
                    }
                    ?>
                </div>
            <?php
            } else {
            ?>
                <div class="alert alert-info" role="alert">
                    抱歉！目前還沒有任何訂單。
                </div>
            <?php
            }
            ?>
            <!-- 頁碼 -->
            <div class="row mt-2">
                <div class="col-md-12">
                    <?php
                    if (isset($_GET['totalRows_rs'])) {
                        $totalRows_rs = $_GET['totalRows_rs'];
                    } else {
                        $all_rs = $link->query($queryFirst);
                        $totalRows_rs = $all_rs->rowCount();
                    }
                    $totalPages_rs = ceil($totalRows_rs / $maxRows_rs) - 1;
                    //呼叫分頁功能
                    $prev_rs = "&laquo;";
                    $next_rs = "&raquo;";
                    $separator = "|";
                    $max_links = 20;
                    $pages_rs = buildNavigation($pageNum_rs, $totalPages_rs, $prev_rs, $next_rs, $separator, $max_links, true, 3, "order_rs");
                    ?>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">

                            <?php
                            echo $pages_rs[0] . $pages_rs[1] . $pages_rs[2];
                            ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    </div>


    <?php require_once("footer.php") ?>
    <?php require_once("jsfile.php") ?>
</body>

</html>