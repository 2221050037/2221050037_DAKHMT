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
    $rs = mysqli_query($conn, "
        SELECT ctdh.*, dh.id AS id_don
        FROM chi_tiet_don_hang ctdh
        JOIN don_hang dh ON ctdh.id_don_hang = dh.id
        WHERE ctdh.id = $idCT
          AND dh.id_nguoi_dung = $maTK
          AND dh.id_trang_thai = 1
    ");
    $ct = mysqli_fetch_assoc($rs);

    if (!$ct) {
        die("Dữ liệu không hợp lệ");
    }

    $tongTien = $ct['gia'] * $ct['so_luong'];
    $idDon    = $ct['id_don'];
}


elseif ($idDon > 0) {
    $rs = mysqli_query($conn, "
        SELECT *
        FROM don_hang
        WHERE id = $idDon
          AND id_nguoi_dung = $maTK
          AND id_trang_thai = 1
    ");
    $donHang = mysqli_fetch_assoc($rs);

    if (!$donHang) {
        die("Đơn hàng không tồn tại");
    }

    $tongTien = $donHang['tong_tien'];
} else {
    die("Thiếu dữ liệu thanh toán");
}


if (isset($_POST['phuong_thuc'])) {
    $pt = $_POST['phuong_thuc'];

    
    if ($pt === 'cod') {
        mysqli_query($conn, "
            UPDATE don_hang
            SET id_trang_thai = 3
            WHERE id = $idDon
        ");
        header("Location: hoanthanh.php?id=$idDon");
        exit();
    }

   
    if ($pt === 'bank') {
        mysqli_query($conn, "
            UPDATE don_hang
            SET id_trang_thai = 2
            WHERE id = $idDon
        ");
        header("Location: hoanthanh.php?id=$idDon");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Thanh toán</title>
<style>
body{font-family:Arial;background:#f5f5f5;padding:40px}
.box{max-width:600px;margin:auto;background:#fff;padding:30px;border-radius:10px}
h1{text-align:center}
.total{font-size:22px;font-weight:bold;text-align:center;margin:20px 0}
.method{margin:15px 0}
.qr{text-align:center;margin-top:15px}
button{width:100%;padding:12px;background:#ff6b6b;color:#fff;border:none;border-radius:6px;font-size:16px;cursor:pointer}
</style>
</head>
<body>

<div class="box">
<h1>Thanh toán</h1>

<div class="total">
Tổng tiền: <?php echo number_format($tongTien,0,',','.'); ?> đ
</div>

<form method="post">

<div class="method">
<label>
<input type="radio" name="phuong_thuc" value="bank" required>
 Chuyển khoản bằng QR
</label>
</div>

<div class="qr">
<img src="../img/qr.png" width="200">
<p>
Ngân hàng: <b>VCB</b><br>
STK: <b>123456789</b><br>
Nội dung: <b>BS<?php echo $idDon; ?></b>
</p>
</div>

<div class="method">
<label>
<input type="radio" name="phuong_thuc" value="cod">
 Thanh toán khi nhận hàng (COD)
</label>
</div>

<button type="submit">Xác nhận thanh toán</button>

</form>
</div>

</body>
</html>
