<div id="good_content">
    <?php require_once("breadcrumb.php") ?>

    <!-- 上半區 -->
    <div id="orderbox">


        <!-- 左半圖片區 -->
        <div class="order-left">
            <div class="side-img">
                <?php
                $SQLstring = sprintf("SELECT * FROM product_img WHERE product_img.p_id=%d ORDER BY sort", $_GET['p_id']);
                $img_rs = $link->query($SQLstring);
                $imgList = $img_rs->fetch();
                $mainImage_rs = $link->query($SQLstring);
                $mainImage = $mainImage_rs->fetch();
                $datastring = sprintf("SELECT * FROM product WHERE product.p_id=%d AND p_open=1 ORDER BY p_id", $_GET['p_id']);
                $data_rs = $link->query($datastring);
                $dataList = $data_rs->fetch();
                ?>

                <table>
                    <?php
                    do {
                    ?>
                        <tr>
                            <td><img src="./images/<?php echo $imgList['img_file']; ?>" class="img-fluid w-75 side-img-item"></td>
                        </tr>
                    <?php
                    } while ($imgList = $img_rs->fetch());
                    ?>
                </table>
            </div>
            <div class="show-img">
                <img src="./images/<?php echo $mainImage['img_file']; ?>" class="img-fluid" id="showGoods">
            </div>
        </div>



        <!-- 右半下單區 -->
        <div class="order-right">
            <h5 class="order-title"><?php echo $dataList['p_name']; ?></h5>
            <p class="card-text"><?php echo $dataList['p_intro']; ?></p>
            <p class="order-price">$<?php echo $dataList['p_price']; ?></p>
            <p class="card-text">數量<br>
            <div class="input-group order-num">
                <input type="type" class="form-control" value="0" onkeypress="return isNumberKey(event)"
                    onchange="validateInput(this)" id="numberInput">
                <button class="btn btn-outline-dark" type="button" onclick="increaseValue()">+</button>
                <button class="btn btn-outline-dark" type="button" onclick="decreaseValue()">-</button>
            </div>
            </p>
            <button class="btn btn-reon-b-order" type="button" onclick="addcart(<?php echo $dataList['p_id']; ?>)"><i class="fa-solid fa-cart-shopping"></i> 加入購物車</button>
            <br>
            <?php
            $listString = sprintf("SELECT * FROM wishlist WHERE p_id=%d", $_GET['p_id']);
            $list = $link->query($listString);
            if ($list_Rows = $list->fetch()) {
            ?>
                <button class="btn btn-reon-added" onclick="removewishlist(<?php echo $dataList['p_id'] ?>)"><i class="fa-solid fa-heart"></i> 移除收藏</button>

            <?php
            } else {
            ?>
                <button class="btn btn-reon-wish" onclick="addwishlist(<?php echo $dataList['p_id'] ?>)"><i class="fa-regular fa-heart"></i> 加入收藏</button>
            <?php
            }
            ?>

        </div>
    </div>


    <!-- 下半區 -->
    <div id="product_intro">
        <h4>商品介紹</h4>
        <?php echo $dataList['p_content']; ?>
    </div>

</div>