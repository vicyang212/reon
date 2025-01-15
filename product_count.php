<script>
    // 修改商品數量
    $("input").change(function() {
        var qty = $(this).val();
        const cartid = $(this).attr("cartid");
        if (qty <= 0 || qty >= 50) {
            alert("商品數量需在1至50之間");
            return false;
        }
        $.ajax({
            url: 'change_qty.php',
            type: 'post',
            dataType: 'json',
            data: {
                cartid: cartid,
                qty: qty,
            },
            success: function(data) {
                if (data.c == true) {
                    window.location.reload();
                } else {
                    alert(data.m);
                }
            },
            error: function(data) {
                alert("系統無法連上資料庫");
            }
        });
    })
</script>