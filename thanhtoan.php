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


$idCT  = isset($_GET['id_ct'])  ? (int)$_GET['id_ct']  : 0;
$idDon = isset($_GET['id_don']) ? (int)$_GET['id_don'] : 0;

$tongTien = 0;


if ($idCT > 0) {

    $sql = "
        SELECT ctdh.*, dh.id AS id_don
        FROM chi_tiet_don_hang ctdh
        JOIN don_hang dh ON ctdh.id_don_hang = dh.id
        WHERE ctdh.id = $idCT
          AND dh.id_nguoi_dung = $maTK
          AND dh.id_trang_thai = 1
    ";
    $rs = mysqli_query($conn, $sql);
    $ct = mysqli_fetch_assoc($rs);

    if (!$ct) {
        die("Dữ liệu không hợp lệ");
    }

    $tongTien = $ct['gia'] * $ct['so_luong'];
    $idDon    = $ct['id_don'];

} elseif ($idDon > 0) {

    $sql = "
        SELECT *
        FROM don_hang
        WHERE id = $idDon
          AND id_nguoi_dung = $maTK
          AND id_trang_thai = 1
    ";
    $rs = mysqli_query($conn, $sql);
    $donHang = mysqli_fetch_assoc($rs);

    if (!$donHang) {
        die("Đơn hàng không tồn tại");
    }

    $tongTien = $donHang['tong_tien'];

} else {
    die("Thiếu dữ liệu thanh toán");
}

if (isset($_POST['xac_nhan'])) {

    $sdt    = trim($_POST['sdt']);
    $diaChi = trim($_POST['dia_chi']);

    if ($sdt === '' || $diaChi === '') {
        die("Vui lòng nhập đầy đủ số điện thoại và địa chỉ");
    }

    
    $fullDiaChi = mysqli_real_escape_string(
        $conn,
        $sdt . " | " . $diaChi
    );

    mysqli_query($conn, "
        UPDATE don_hang
        SET id_trang_thai = 2,
            id_dia_chi = '$fullDiaChi'
        WHERE id = $idDon
          AND id_nguoi_dung = $maTK
    ");

    header("Location: hoanthanh.php?id=$idDon");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Xác nhận đặt hàng</title>
<style>
body{
    font-family:Arial, Helvetica, sans-serif;
    background:#f5f5f5;
    padding:40px
}
.box{
    max-width:600px;
    margin:auto;
    background:#fff;
    padding:30px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.1)
}
h1{
    text-align:center;
    margin-bottom:20px
}
.total{
    font-size:22px;
    font-weight:bold;
    text-align:center;
    margin:20px 0;
    color:#e74c3c
}
input[type=text]{
    width:100%;
    padding:10px;
    margin-top:8px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:5px
}
button{
    width:100%;
    padding:12px;
    background:#ff6b6b;
    color:#fff;
    border:none;
    border-radius:6px;
    font-size:16px;
    cursor:pointer
}
button:hover{
    background:#ff4c4c
}
.note{
    margin-top:15px;
    background:#f0f8ff;
    padding:10px;
    border-left:4px solid #2d2dfc;
    font-size:14px
}
</style>
</head>
<body>

<div class="box">
<h1>🧾 Xác nhận đặt hàng</h1>

<div class="total">
Tổng tiền: <?php echo number_format($tongTien,0,',','.'); ?> đ
</div>

<form method="post">

<b>Số điện thoại nhận hàng</b>
<input type="text" name="sdt" placeholder="Nhập số điện thoại" required>

<b>Địa chỉ giao hàng</b>
<input type="text" name="dia_chi" placeholder="Nhập địa chỉ nhận hàng" required>

<div class="note">
Hình thức thanh toán: <b>Trả tiền khi nhận hàng (COD)</b><br>
Thanh toán sau khi nhận hàng
</div>

<button type="submit" name="xac_nhan">
Xác nhận đặt hàng
</button>

</form>
</div>

</body>
</html>
