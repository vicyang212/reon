<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json; charset=utf-8');
require_once('Connections/dbset.php');

if (isset($_GET['p_id']) && isset($_GET['qty'])) {
    $p_id = $_GET['p_id'];
    $qty = $_GET['qty'];
    $u_ip = $_SERVER['REMOTE_ADDR'];
    // 確認有沒有重複的產品
    $query = "SELECT * FROM cart WHERE p_id=" . $p_id . " AND ip='" . $_SERVER['REMOTE_ADDR'] . "' AND orderid IS NULL";
    $result = $link->query($query);
    if ($result) {
        if ($result->rowCount() == 0) {
            $query = "INSERT INTO cart (p_id, qty, ip) VALUES (" . $p_id . "," . $qty . ",'" . $u_ip . "')";
        } else {
            $cart_data = $result->fetch();
            if ($cart_data['qty'] + $qty > 50) {
                $qty = 50;
            } else {
                $qty = $qty + $cart_data['qty'];
            }
            $query = "UPDATE cart SET qty='" . $qty . "' WHERE cart.cartid=" . $cart_data['cartid'];
        }
        $result = $link->query($query);
        $retcode = array("c" => "1", "m" => "謝謝您！商品已經放進購物車！");
    } else {
        $retcode = array("c" => "0", "m" => "無法連接購物車，請與管理員聯絡");
    }
    echo json_encode($retcode, JSON_UNESCAPED_UNICODE);
}
return;
