<?php
$level1Open = "";
$level2Open = "";
$level3Open = "";
$level4Open = "";

if (isset($_GET['search_name'])) {
    $level1Open = '<li class="breadcrumb-item active" aria-current="page">關鍵字：' . $_GET['search_name'] . '</li>';
} else if (isset($_GET['classid'])) {
    // 先查詢當前類別的資訊
    $SQLstring = sprintf("SELECT * FROM class WHERE classid=%d", $_GET['classid']);
    $classid_rs = $link->query($SQLstring);
    if ($data = $classid_rs->fetch()) {
        switch ($data['level']) {
            case 1:
                // 第一層類別
                $level1Cname = $data['cname'];
                $level1Open = '<li class="breadcrumb-item active" aria-current="page">' . $level1Cname . '</li>';
                break;

            case 2:
                // 第二層類別
                $level2Cname = $data['cname'];
                $level2Uplink = $data['uplink'];
                $level2Open = '<li class="breadcrumb-item active" aria-current="page">' . $level2Cname . '</li>';

                // 向上查詢第一層
                $SQLstring = sprintf("SELECT * FROM class WHERE level=1 and classid=%d", $level2Uplink);
                $classid_rs = $link->query($SQLstring);
                if ($data = $classid_rs->fetch()) {
                    $level1Cname = $data['cname'];
                    $level1Open = '<li class="breadcrumb-item"><a href="shopping.php?classid=' . $data['classid'] . '">' . $level1Cname . '</a></li>';
                }
                break;

            case 3:
                // 第三層類別
                $level3Cname = $data['cname'];
                $level3Uplink = $data['uplink'];
                $level3Open = '<li class="breadcrumb-item active" aria-current="page">' . $level3Cname . '</li>';

                // 向上查詢第二層
                $SQLstring = sprintf("SELECT * FROM class WHERE level=2 and classid=%d", $level3Uplink);
                $classid_rs = $link->query($SQLstring);
                if ($data = $classid_rs->fetch()) {
                    $level2Cname = $data['cname'];
                    $level2Uplink = $data['uplink'];
                    $level2Open = '<li class="breadcrumb-item"><a href="shopping.php?classid=' . $data['classid'] . '">' . $level2Cname . '</a></li>';

                    // 繼續向上查詢第一層
                    $SQLstring = sprintf("SELECT * FROM class WHERE level=1 and classid=%d", $level2Uplink);
                    $classid_rs = $link->query($SQLstring);
                    if ($data = $classid_rs->fetch()) {
                        $level1Cname = $data['cname'];
                        $level1Open = '<li class="breadcrumb-item"><a href="shopping.php?classid=' . $data['classid'] . '">' . $level1Cname . '</a></li>';
                    }
                }
                break;
        }
    }
}
// 處理產品層級（第四層）
if (isset($_GET['p_id'])) {
    // 查詢產品資訊
    $SQLstring = sprintf("SELECT * FROM product WHERE p_id=%d", $_GET['p_id']);
    $product_rs = $link->query($SQLstring);
    if ($product = $product_rs->fetch()) {
        // 顯示產品名稱作為第四層
        $level4Open = '<li class="breadcrumb-item active" aria-current="page">' . $product['p_name'] . '</li>';

        // 向上查詢第三層類別
        $SQLstring = sprintf("SELECT * FROM class WHERE level=3 and classid=%d", $product['classid']);
        $classid_rs = $link->query($SQLstring);
        if ($data = $classid_rs->fetch()) {
            $level3Cname = $data['cname'];
            $level3Uplink = $data['uplink'];
            $level3Open = '<li class="breadcrumb-item"><a href="shopping.php?classid=' . $data['classid'] . '">' . $level3Cname . '</a></li>';

            // 向上查詢第二層
            $SQLstring = sprintf("SELECT * FROM class WHERE level=2 and classid=%d", $level3Uplink);
            $classid_rs = $link->query($SQLstring);
            if ($data = $classid_rs->fetch()) {
                $level2Cname = $data['cname'];
                $level2Uplink = $data['uplink'];
                $level2Open = '<li class="breadcrumb-item"><a href="shopping.php?classid=' . $data['classid'] . '">' . $level2Cname . '</a></li>';

                // 向上查詢第一層
                $SQLstring = sprintf("SELECT * FROM class WHERE level=1 and classid=%d", $level2Uplink);
                $classid_rs = $link->query($SQLstring);
                if ($data = $classid_rs->fetch()) {
                    $level1Cname = $data['cname'];
                    $level1Open = '<li class="breadcrumb-item"><a href="shopping.php?classid=' . $data['classid'] . '">' . $level1Cname . '</a></li>';
                }
            }
        } else {
            $SQLstring = sprintf("SELECT * FROM class WHERE level=2 and classid=%d", $product['classid']);
            $classid_rs = $link->query($SQLstring);
            if ($data = $classid_rs->fetch()) {
                $level2Cname = $data['cname'];
                $level2Uplink = $data['uplink'];
                $level2Open = '<li class="breadcrumb-item"><a href="shopping.php?classid=' . $data['classid'] . '">' . $level2Cname . '</a></li>';

                // 向上查詢第一層
                $SQLstring = sprintf("SELECT * FROM class WHERE level=1 and classid=%d", $level2Uplink);
                $classid_rs = $link->query($SQLstring);
                if ($data = $classid_rs->fetch()) {
                    $level1Cname = $data['cname'];
                    $level1Open = '<li class="breadcrumb-item"><a href="shopping.php?classid=' . $data['classid'] . '">' . $level1Cname . '</a></li>';
                }
            }
        }
    }
}
?>

<!-- 目前位置 -->
<nav aria-label="breadcrumb" id="breadcrumb">
    <ol class="breadcrumb bread">
        <?php echo $level1Open . $level2Open . $level3Open . $level4Open; ?>
    </ol>
    <ol class="breadcrumb bread-m">
        <?php echo $level1Open . $level2Open . $level3Open; ?>
    </ol>
</nav>