<div id="sidebar">
    <div id="sidebar_background">
        <a href="shopping.php">
            <div class="sidebar-all">全部商品</div>
        </a>
        <a href="shopping_reonstar.php">
            <div class="sidebar-star">REON明星商品</div>
        </a>

        <?php
        // 列出產品第一層
        $SQLstring = "SELECT * FROM class WHERE level=1 ORDER BY sort";
        $class01 = $link->query($SQLstring);
        $i = 1; //控制編號順序
        ?>
        <?php
        while ($class01_Rows = $class01->fetch()) {
        ?>
            <div class="sidebar-level01"><a href="shopping.php?classid=<?php echo $class01_Rows['classid'] ?>"><span class="span01"><?php echo $class01_Rows['cname'] ?></span></a>

                <?php
                // 列出產品第二層
                $SQLstring = sprintf("SELECT * FROM class WHERE level=2 AND uplink=%d ORDER BY sort", $class01_Rows['classid']);
                $class02 = $link->query($SQLstring);
                while ($class02_Rows = $class02->fetch()) {
                ?>
                    <div class="sidebar-level02"><a href="shopping.php?classid=<?php echo $class02_Rows['classid']; ?>">
                            <div><?php echo $class02_Rows['cname'] ?></div>
                        </a>
                    </div>
                    <div class="sidebar-level03">
                        <?php
                        // 列出產品第三層
                        $SQLstring = sprintf("SELECT * FROM class WHERE level=3 AND uplink=%d ORDER BY sort", $class02_Rows['classid']);
                        $class03 = $link->query($SQLstring);
                        while ($class03_Rows = $class03->fetch()) {
                        ?>
                            <a href="shopping.php?classid=<?php echo $class03_Rows['classid']; ?>"><span><?php echo $class03_Rows['cname'] ?></span></a>
                        <?php } ?>

                    </div>

                <?php } ?>
            </div>
        <?php
            $i++;
        }
        ?>
    </div>
</div>