<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json; charset=utf-8');
require_once('Connections/dbset.php');

// 檢查是否登入
session_start();
if (!isset($_SESSION['login']) || !isset($_SESSION['emailid'])) {
    // 尚未登入的回應
    $response = array("c" => "0", "m" => "尚未登入，請先登入！");
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}

// 檢查是否有接收到 `p_id`
if (isset($_GET['p_id'])) {
    $p_id = intval($_GET['p_id']); // 確保 `p_id` 是整數
    $emailid = $_SESSION['emailid']; // 使用者的 email 作為帳號

    // 刪除收藏商品
    $deleteQuery = "DELETE FROM wishlist WHERE p_id = :p_id AND emailid = :emailid";
    $deleteStmt = $link->prepare($deleteQuery);
    $deleteStmt->bindParam(':p_id', $p_id, PDO::PARAM_INT);
    $deleteStmt->bindParam(':emailid', $emailid, PDO::PARAM_STR);

    if ($deleteStmt->execute()) {
        $response = array("c" => "1", "m" => "商品已成功從收藏清單中移除！");
    } else {
        $response = array("c" => "0", "m" => "無法移除商品，請稍後再試！");
    }
} else {
    // 缺少必要的參數
    $response = array("c" => "0", "m" => "缺少商品 ID，無法執行操作！");
}

// 回傳 JSON 結果
echo json_encode($response, JSON_UNESCAPED_UNICODE);
