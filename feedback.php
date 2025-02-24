<?php
if (isset($_POST['flag'])) {
    require_once("Connections/dbset.php");
    $cname = $_POST['cname'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $message = $_POST['message'];
    $SQLstring = sprintf("INSERT INTO feedback (cname, tel, email, address, message) VALUES ('%s', '%s', '%s', '%s', '%s')", $cname, $tel, $email, $address, $message);
    $result = $link->query($SQLstring);
    if ($result) {
        echo "<script>alert('已經收到您的訊息囉！謝謝您寶貴的意見！');</script>";
    } else {
        echo "<script>alert('糟糕！訊息發送不成功，請與管理員聯絡！');</script>";
    }
}
?>