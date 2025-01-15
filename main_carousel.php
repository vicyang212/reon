<div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner showing-pic">
            <?php
            $SQLstring = "SELECT * FROM carousel WHERE caro_online=1 ORDER BY caro_sort";
            $carousel = $link->query($SQLstring);
            $i = 0; //控制active啟動
            while ($data = $carousel->fetch()) {
            ?>
                <div class="carousel-item  <?php echo activeShow($i, 0) ?>" data-bs-interval="5000">
                    <a href="shopping.php?classid=<?php echo $data['class_id'] ?>">
                        <img src="./images/<?php echo $data['caro_pic']; ?>" class="d-block w-100" alt="..."></a>
                </div>
            <?php
                $i++;
            }
            ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>