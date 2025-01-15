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

if (isset($_GET['p_id'])) {
    $p_id = $_GET['p_id'];
    $emailid = $_SESSION['emailid']; // 使用者的 email 作為帳號

    $query = "SELECT * FROM wishlist WHERE p_id = :p_id AND emailid = :emailid";
    $stmt = $link->prepare($query);
    $stmt->bindParam(':p_id', $p_id, PDO::PARAM_INT);
    $stmt->bindParam(':emailid', $emailid, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        $insertQuery = "INSERT INTO wishlist (p_id, emailid) VALUES (:p_id, :emailid)";
        $insertStmt = $link->prepare($insertQuery);
        $insertStmt->bindParam(':p_id', $p_id, PDO::PARAM_INT);
        $insertStmt->bindParam(':emailid', $emailid, PDO::PARAM_STR);
        $insertStmt->execute();

        $response = array("c" => "1", "m" => "商品已成功加入收藏！");
    } else {
        $response = array("c" => "1", "m" => "該商品已在收藏清單中！");
    }
} else {
    $response = array("c" => "0", "m" => "缺少商品 ID，無法新增！");
}

// 回傳 JSON 結果
echo json_encode($response, JSON_UNESCAPED_UNICODE);
