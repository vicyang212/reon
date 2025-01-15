<!-- 新版navbar -->
<section class="navbar-wrapper-new">
    <nav class="navbar-new">
        <a href="main.php">
            <img src="images/REON_LOGO-2.png" title="REON里光眼鏡" class="logo-pic">
        </a>
        <!-- 選單欄 -->
        <ul class="nav-menu-new">
        <li class="nav-item-new"><a href="shopping.php">全部商品</a></li>
            <?php
            // 列出產品第一層
            $SQLstring = "SELECT * FROM class WHERE level=1 ORDER BY sort";
            $class01 = $link->query($SQLstring);
            $i = 1; //控制編號順序
            ?>
            <?php
            while ($class01_Rows = $class01->fetch()) {
            ?>
                <li class="nav-item-new">
                    <a href="shopping.php?classid=<?php echo $class01_Rows['classid']; ?>">
                        <?php echo $class01_Rows['cname'] ?>
                    </a>
                    <div class="dropdown-new">
                        <div class="dropdown-new-content">

                            <?php
                            // 列出產品第二層
                            $SQLstring = sprintf("SELECT * FROM class WHERE level=2 AND uplink=%d ORDER BY sort", $class01_Rows['classid']);
                            $class02 = $link->query($SQLstring);
                            while ($class02_Rows = $class02->fetch()) {
                            ?>
                                <div class="dropdown-new-section">
                                    <a class="dropdown-new-title" href="shopping.php?classid=<?php echo $class02_Rows['classid']; ?>">
                                        <?php echo $class02_Rows['cname'] ?> </a>

                                    <div class="dropdown-new-list">

                                        <div class="dropdown-new-item">
                                            <?php
                                            // 列出產品第三層
                                            $SQLstring = sprintf("SELECT * FROM class WHERE level=3 AND uplink=%d ORDER BY sort", $class02_Rows['classid']);
                                            $class03 = $link->query($SQLstring);
                                            while ($class03_Rows = $class03->fetch()) {
                                            ?>
                                                <a href="shopping.php?classid=<?php echo $class03_Rows['classid']; ?>" class="dropdown-new-link"><?php echo $class03_Rows['cname'] ?></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </li>
            <?php
                $i++;
            }
            ?>
        </ul>
        <div class="right-menu">
            <?php
            if (!isset($_SESSION['login'])) {
            ?>
                <a href="login.php">
                <?php
            } else {
                ?>
                    <a href="login-index.php">
                    <?php
                }
                    ?>
                    <i class="fa-regular fa-circle-user fa-lg"></i></a>
                    <a href="wish_list.php"><i class="fa-regular fa-heart fa-lg"></i></a>

                    <a href="#">
                        <i class="fa-solid fa-cart-shopping fa-lg position-relative" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                            <span class="position-absolute start-100 translate-middle badge rounded-pill text-bg-warning" style="font-size: 10px;top:-12px;">
                                <?php
                                $stmt = $link->prepare("SELECT SUM(qty) AS total_quantity FROM cart WHERE orderid IS NULL AND ip = :ip");
                                $stmt->bindParam(':ip', $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
                                $stmt->execute();
                                $total_quantity = $stmt->fetchColumn();
                                ?>
                                <?php
                                echo htmlspecialchars($total_quantity, ENT_QUOTES, 'UTF-8');
                                ?></span>
                        </i>
                    </a>

                    <form action="shopping.php" method="get" id="search">
                        <div class="input-group input-group-sm mb-3" style="padding-top: 18px;">
                            <input type="search" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="button-addon2" name="search_name" id="search_name" value="<?php echo (isset($_GET['search_name'])) ? $_GET['search_name'] : ''; ?>" required>
                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </form>

        </div>
        </ul>
    </nav>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">購物車</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <?php
            $SQLstring = "SELECT * FROM cart JOIN product ON cart.p_id = product.p_id WHERE orderid IS NULL ORDER BY cartid";
            $cart_rs = $link->query($SQLstring);
            $subtotal = 0;
            ?>
            <?php
            if ($cart_rs->rowCount() > 0) {  // 確認購物車是否有商品
            ?>
                <table id="cart_table">
                    <tr style="margin-bottom: 5px;">
                        <td style="width: 60%;">名稱</td>
                        <td style="width: 20%;text-align:center;">數量</td>
                        <td style="width: 20%;text-align:center;">金額</td>
                    </tr>
                    <?php
                    while ($cartList = $cart_rs->fetch()) {
                        $lineTotal = $cartList['p_price'] * $cartList['qty'];
                        $subtotal += $lineTotal;
                    ?>
                        <tr class="cart_tr">
                            <td class="cart_td"><?php echo htmlspecialchars($cartList['p_name']); ?></td>
                            <td style="width: 20%;text-align:center" class="cart_td"><?php echo htmlspecialchars($cartList['qty']); ?></td>
                            <td style="width: 20%;text-align:center" class="cart_td"><?php echo htmlspecialchars($lineTotal); ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                    <tr style="border: none;">
                        <td>小計</td>
                        <td colspan="2" style="text-align:right;font-weight:bolder;">$<?php echo htmlspecialchars($subtotal); ?></td>
                    </tr>
                </table>
                <br>
                <p style="text-align:right;"> <a href="./cart.php"><button class="btn btn-reon-b-order">修改 / 結帳</button></a></p>
        </div>
    <?php
            } else {
                echo "<br><p>購物車空空如也！快去下單吧！</p><br><p style='text-align:right;'> <a href='./cart.php'><button class='btn btn-reon-b-order'>修改 / 結帳</button></a></p>";
            }
    ?>
    </div>


</section>

<!-- 行動版 -->
<section class="navbar-wrapper-new-m">
    <nav class="navbar-new-m">
        <a href="main.php">
            <img src="images/REON_LOGO-2.png" title="REON里光眼鏡" class="logo-pic">
        </a>
        <div>
            <?php
            if (!isset($_SESSION['login'])) {
            ?>
                <a href="login.php">
                <?php
            } else {
                ?>
                    <a href="login-index.php">
                    <?php
                }
                    ?><i class="fa-regular fa-circle-user"></i></a>
                    <a href="wish_list.php"><i class="fa-regular fa-heart"></i></a>
                    <a href="./cart.php"><i class="fa-solid fa-cart-shopping">
                            <span class="position-absolute translate-middle badge rounded-pill text-bg-warning">
                                <?php
                                $stmt = $link->prepare("SELECT SUM(qty) AS total_quantity FROM cart WHERE orderid IS NULL AND ip = :ip");
                                $stmt->bindParam(':ip', $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
                                $stmt->execute();
                                $total_quantity = $stmt->fetchColumn();
                                ?>
                                <?php
                                echo htmlspecialchars($total_quantity, ENT_QUOTES, 'UTF-8');
                                ?></span>
                        </i></a>
                    <i class="fa-solid fa-bars fa-2xl" style="color: #949494;margin-left:1rem; cursor:pointer;"></i>
        </div>
    </nav>

    <div class="side-menu">
        <div class="side-menu-content">
            <ul class="side-menu-1">
                <li class="side-item-1">
                    <div class="item-title">
                        <a href="shopping.php">全部商品</a>
                    </div>
                </li>
            </ul>
            <ul class="side-menu-1">
                <li class="side-item-1">
                    <div class="item-title">
                        <a href="shopping_reonstar.php">REON明星商品</a>
                    </div>
                </li>
            </ul>
            <ul class="side-menu-1">
                <?php
                // 列出產品第一層
                $SQLstring = "SELECT * FROM class WHERE level=1 ORDER BY sort";
                $class01 = $link->query($SQLstring);
                $i = 1; //控制編號順序
                ?>
                <?php
                while ($class01_Rows = $class01->fetch()) {
                ?>
                    <li class="side-item-1">
                        <div class="item-title"><a href="shopping.php?classid=<?php echo $class01_Rows['classid']; ?>">
                                <?php echo $class01_Rows['cname'] ?>
                            </a>
                            <i class="fa-solid fa-chevron-down fa-sm icon1"></i>
                        </div>
                        <ul class="side-menu-2">
                            <?php
                            // 列出產品第二層
                            $SQLstring = sprintf("SELECT * FROM class WHERE level=2 AND uplink=%d ORDER BY sort", $class01_Rows['classid']);
                            $class02 = $link->query($SQLstring);
                            while ($class02_Rows = $class02->fetch()) {
                                $SQLstring_check = sprintf("SELECT COUNT(*) as count FROM class WHERE level=3 AND uplink=%d", $class02_Rows['classid']);
                                $class03_check = $link->query($SQLstring_check);
                                $has_third_level = ($class03_check->fetch()['count'] > 0);
                            ?>
                                <li class="side-item-2">
                                    <div class="item-title"><a href="shopping.php?classid=<?php echo $class02_Rows['classid']; ?>"><?php echo $class02_Rows['cname'] ?> </a><?php if ($has_third_level) { ?>
                                            <i class="fa-solid fa-chevron-down fa-sm icon2"></i>
                                        <?php } ?>
                                    </div>
                                    <ul class="side-menu-3">
                                        <?php
                                        // 列出產品第三層
                                        $SQLstring = sprintf("SELECT * FROM class WHERE level=3 AND uplink=%d ORDER BY sort", $class02_Rows['classid']);
                                        $class03 = $link->query($SQLstring);
                                        while ($class03_Rows = $class03->fetch()) {
                                        ?>
                                            <li class="side-item-3"><a href="shopping.php?classid=<?php echo $class03_Rows['classid']; ?>"><?php echo $class03_Rows['cname'] ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php
                    $i++;
                }
                ?>
            </ul>
        </div>
        <form action="shopping.php" method="get" id="search">
            <div class="input-group input-group-sm mb-3" style="padding-top: 18px;">
                <input type="search" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="button-addon2" name="search_name" id="search_name" value="<?php echo (isset($_GET['search_name'])) ? $_GET['search_name'] : ''; ?>" required>
                <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </form>
        <br>
    </div>
</section>