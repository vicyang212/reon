// 商品側欄圖片轉換
$(function() {
    $(".side-img a").mouseover(function() {
        var imgsrc = $(this).children("img").attr("src");
        $('#showGoods').attr("src", imgsrc);
    });
});

// 回到最上面按鈕
// const gotopspace = document.getElementById('gotopspace');
// window.onscroll = function() {
//     if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
//         gotopspace.classList.add('visible');
//     } else {
//         gotopspace.classList.remove('visible');
//     }
// };

// 下單數量按鈕
const input = document.getElementById('numberInput');
const minValue = 0; // 設置最小值
const maxValue = 50; // 設置最大值

function increaseValue() {
    let value = parseInt(input.value) || 0;
    if (value < maxValue) {
        input.value = value + 1;
    } else {
        alert(`數值不能大於 ${maxValue}`);
    }
}

function decreaseValue() {
    let value = parseInt(input.value) || 0;
    if (value > minValue) {
        input.value = value - 1;
    } else {
        alert(`數值不能小於 ${minValue}`);
    }
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function validateInput(el) {
    let value = parseInt(el.value) || 0;
    let originalValue = value;

    if (value < minValue) {
        value = minValue;
        alert(`訂購數量 ${originalValue} 太少囉！必須至少訂購 ${minValue} 件`);
    }
    if (value > maxValue) {
        value = maxValue;
        alert(`訂購數量 ${originalValue} 超過上限了！本產品最多只能訂購 ${maxValue} 件，若有批量需求請聯絡本店`);
    }
    el.value = value;
}


// 防止粘貼非數字內容
// input.addEventListener('paste', (e) => {
//     let pasteData = e.clipboardData.getData('text');
//     if (!(/^\d*$/.test(pasteData))) {
//         e.preventDefault();
//     }
// });


// 加入購物車
function addcart(p_id) {
    var qty = $("#numberInput").val();
    if (qty <= 0) {
        alert("您沒有輸入需要的數量，請修改數量");
        return (false);
    }
    if (qty == undefined) {
        qty = 1;
    } else if (qty > 50) {
        alert("訂購數量超過採購限制，請調整數量");
        return (false);
    }
    // 用jquery $.ajax函數呼叫後台的addcart.php
    $.ajax({
        url: 'addcart.php',
        type: 'get',
        dataType: 'json',
        data: {
            p_id: p_id,
            qty: qty,
        },
        success: function(data) {
            if (data.c == "1") { // 修正判斷條件
                alert(data.m);
                window.location.reload();
            } else {
                alert(data.m);
            }
        },
        error: function(data) {
            alert("資料庫連線失敗");
        }
    });
}

//cart_content單筆取消功能
function btn_confirmLink(message, url) {
    if (message == "" || url == "") {
        return false;
    }
    if (confirm(message)) {
        window.location = url;
    }
    return false;
}


