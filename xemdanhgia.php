<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("../admin/connect.php");

if (!isset($_SESSION["MaTK"])) {
    header("Location: ../dangnhap.php");
    exit();
}
$maTK = (int)$_SESSION["MaTK"];


if (!isset($_GET['id_don']) || !isset($_GET['id_sach'])) {
    die("Thiếu thông tin đánh giá");
}

$idDon  = (int)$_GET['id_don'];
$idSach = (int)$_GET['id_sach'];


$rs = mysqli_query($conn, "
    SELECT dg.*, s.TuaSach
    FROM danh_gia_sach dg
    JOIN sach s ON dg.id_sach = s.MaSach
    WHERE dg.id_don_hang = $idDon
      AND dg.id_sach = $idSach
      AND dg.id_nguoi_dung = $maTK
");

if (mysqli_num_rows($rs) == 0) {
    die("Không tìm thấy đánh giá");
}

$dg = mysqli_fetch_assoc($rs);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Xem đánh giá</title>

<style>
body{
    background:#f4f6f9;
    font-family: Arial, Helvetica, sans-serif;
}

.container{
    max-width:600px;
    margin:60px auto;
    background:#ffffff;
    padding:30px 35px;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

h2{
    text-align:center;
    margin-bottom:25px;
    color:#333;
}

.info-row{
    margin-bottom:15px;
    font-size:16px;
}

.info-row strong{
    color:#444;
}

.star{
    color:#f5b301;
    font-size:22px;
    letter-spacing:2px;
}

.comment-box{
    background:#f8f9fa;
    border-left:4px solid #28a745;
    padding:15px;
    border-radius:6px;
    margin-top:8px;
    line-height:1.6;
    color:#333;
}

.date{
    font-size:14px;
    color:#777;
    margin-top:15px;
}

.back{
    display:inline-block;
    margin-top:30px;
    padding:10px 18px;
    background:#2d2dfc;
    color:#fff;
    text-decoration:none;
    border-radius:6px;
    font-size:15px;
    transition:0.2s;
}

.back:hover{
    background:#1a1ad9;
}
</style>
</head>

<body>

<div class="container">
    <h2>Đánh giá sách</h2>

    <div class="info-row">
        <strong>Sách:</strong>
        <?= htmlspecialchars($dg['TuaSach']) ?>
    </div>

    <div class="info-row">
        <strong>Số sao:</strong>
        <span class="star">
            <?= str_repeat("⭐", (int)$dg['so_sao']) ?>
        </span>
    </div>

    <div class="info-row">
        <strong>Bình luận:</strong>
        <div class="comment-box">
            <?= nl2br(htmlspecialchars($dg['noi_dung'])) ?>
        </div>
    </div>

    <div class="date">
        <strong>Ngày đánh giá:</strong>
        <?= date("d/m/Y H:i", strtotime($dg['ngay_danh_gia'])) ?>
    </div>

    <a class="back" href="index.php?page=giohang">⬅ Quay lại giỏ hàng</a>
</div>

</body>
</html>
