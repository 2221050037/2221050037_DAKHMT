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

if (!isset($_GET['id'])) {
    header("Location: giohang.php");
    exit();
}

$idDonHang = (int)$_GET['id'];

$sql = "
    SELECT *
    FROM don_hang
    WHERE id = $idDonHang
      AND id_nguoi_dung = $maTK
    LIMIT 1
";
$rs = mysqli_query($conn, $sql);
$donHang = mysqli_fetch_assoc($rs);

if (!$donHang) {
    header("Location: giohang.php");
    exit();
}

$thongBao = '';
$icon     = '';

switch ($donHang['id_trang_thai']) {
    case 2:
        $thongBao = "Đơn hàng của bạn đã được ghi nhận.<br>
                     Vui lòng chờ admin xác nhận.";
        break;

    case 3:

        $thongBao = "Đơn hàng đã được admin xác nhận.<br>
                     Đơn hàng sẽ sớm được giao.";
        break;

    case 4:
        $thongBao = "Đơn hàng đang được giao.<br>
                     Vui lòng chú ý điện thoại khi nhận hàng.";
        break;

    case 5:
        $thongBao = "Đơn hàng đã <b>hoàn thành</b>.<br>
                     Cảm ơn bạn đã mua sắm tại cửa hàng!";
        break;

    default:

        $thongBao = "Trạng thái đơn hàng không xác định.";
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Chi tiết đơn hàng</title>
<style>
body{
    font-family:Arial, Helvetica, sans-serif;
    background:#f5f5f5;
    padding:40px;
}
.box{
    max-width:600px;
    margin:auto;
    background:#fff;
    padding:40px;
    border-radius:10px;
    text-align:center;
    box-shadow:0 4px 10px rgba(0,0,0,.1);
}
.icon{
    font-size:60px;
}
h1{
    margin:20px 0;
}
.info{
    font-size:17px;
    color:#444;
    margin-bottom:30px;
    line-height:1.6;
}
.btn{
    display:inline-block;
    padding:12px 25px;
    background:#2d2dfc;
    color:#fff;
    text-decoration:none;
    border-radius:6px;
    margin:5px;
}
.btn.gray{
    background:#ccc;
    color:#000;
}
</style>
</head>
<body>

<div class="box">
    <div class="icon"><?= $icon ?></div>
    <h1>Chi tiết đơn hàng</h1>

    <div class="info">
        <?= $thongBao ?>
        <br><br>
        <b>Mã đơn hàng:</b> DH<?= $donHang['id'] ?><br>
        <b>Ngày đặt:</b> <?= date("d/m/Y H:i", strtotime($donHang['ngay_dat'])) ?><br>
        <b>Tổng tiền:</b> <?= number_format($donHang['tong_tien'],0,',','.') ?> đ
    </div>

    <a href="index.php?page=giohang" class="btn gray">Quay lại</a>
    <a href="index.php" class="btn">Trang chủ</a>
</div>

</body>
</html>
