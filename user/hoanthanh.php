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


$sql = "
    SELECT *
    FROM don_hang
    WHERE id_nguoi_dung = $maTK
      AND id_trang_thai IN (2,3)
    ORDER BY id DESC
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

if ($donHang['id_trang_thai'] == 3) {
    $icon     = "⏳";
    $thongBao = "Bạn đã gửi yêu cầu thanh toán.<br>
                 Đơn hàng đang <b>chờ xác nhận chuyển khoản</b>.";
}

if ($donHang['id_trang_thai'] == 2) {
    $icon     = "📦";
    $thongBao = "Đơn hàng của bạn đã được ghi nhận.<br>
                 Chúng tôi sẽ <b>giao hàng và thu tiền khi nhận</b>.";
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Hoàn tất đơn hàng</title>
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
    <div class="icon"><?php echo $icon; ?></div>
    <h1>Đặt hàng thành công</h1>

    <div class="info">
        <?php echo $thongBao; ?>
        <br><br>
        <b>Mã đơn hàng:</b> DH<?php echo $donHang['id']; ?><br>
        <b>Tổng tiền:</b> <?php echo number_format($donHang['tong_tien'],0,',','.'); ?> đ
    </div>

    <a href="index.php" class="btn">Về trang chủ</a>
    <a href="donhangcuatoi.php" class="btn gray">Đơn hàng của tôi</a>
</div>

</body>
</html>
