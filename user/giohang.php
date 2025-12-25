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


if (isset($_GET['xoa_ctdh'])) {
    $idCT = (int)$_GET['xoa_ctdh'];

    // Lấy thông tin để trừ tổng tiền
    $rs = mysqli_query($conn, "
        SELECT id_don_hang, so_luong, gia
        FROM chi_tiet_don_hang
        WHERE id = $idCT
    ");
    if ($ct = mysqli_fetch_assoc($rs)) {
        $tienTru = $ct['so_luong'] * $ct['gia'];
        $idDon   = $ct['id_don_hang'];

        mysqli_query($conn, "DELETE FROM chi_tiet_don_hang WHERE id = $idCT");
        mysqli_query($conn, "
            UPDATE don_hang
            SET tong_tien = tong_tien - $tienTru
            WHERE id = $idDon
        ");
    }

    header("Location: giohang.php");
    exit();
}


$sqlDonHang = "
    SELECT *
    FROM don_hang
    WHERE id_nguoi_dung = $maTK
      AND id_trang_thai = 1
    ORDER BY id DESC
    LIMIT 1
";
$rsDonHang = mysqli_query($conn, $sqlDonHang);
$donHang   = mysqli_fetch_assoc($rsDonHang);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body{font-family:Arial;background:#f5f5f5;padding:40px}
        .container{max-width:1100px;margin:auto;background:#fff;padding:30px;border-radius:10px}
        table{width:100%;border-collapse:collapse}
        th,td{border:1px solid #ddd;padding:10px;text-align:center}
        th{background:#2d2dfc;color:#fff}
        img{width:70px;height:100px;object-fit:cover}
        .btn{padding:6px 12px;border-radius:5px;text-decoration:none;color:#fff;font-size:14px}
        .btn-xoa{background:#999}
        .btn-pay{background:#ff6b6b}
        .total{text-align:right;font-size:20px;font-weight:bold;margin-top:20px}
        .actions{text-align:right;margin-top:20px}
        .empty{text-align:center;color:#777;font-size:18px}
    </style>
</head>
<body>

<div class="container">
<h1>Giỏ hàng</h1>

<?php if (!$donHang) { ?>

    <p class="empty">Giỏ hàng trống</p>

<?php } else {

$idDonHang = (int)$donHang['id'];

$rsCT = mysqli_query($conn, "
    SELECT ctdh.*, s.TuaSach, s.HinhAnh
    FROM chi_tiet_don_hang ctdh
    JOIN sach s ON ctdh.id_sach = s.MaSach
    WHERE ctdh.id_don_hang = $idDonHang
");

if (mysqli_num_rows($rsCT) == 0) {
    echo '<p class="empty">Giỏ hàng trống</p>';
} else {
?>

<table>
<tr>
    <th>Sách</th>
    <th>Tên</th>
    <th>Giá</th>
    <th>SL</th>
    <th>Thành tiền</th>
    <th>Thao tác</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($rsCT)) { ?>
<tr>
    <td><img src="./img/<?php echo $row['HinhAnh']; ?>"></td>
    <td><?php echo htmlspecialchars($row['TuaSach']); ?></td>
    <td><?php echo number_format($row['gia'],0,',','.'); ?> đ</td>
    <td><?php echo $row['so_luong']; ?></td>
    <td><?php echo number_format($row['gia']*$row['so_luong'],0,',','.'); ?> đ</td>
    <td>
        <a class="btn btn-xoa"
           href="giohang.php?xoa_ctdh=<?php echo $row['id']; ?>"
           onclick="return confirm('Xóa sách này?')">
           Xóa
        </a>
        <a class="btn btn-pay"
           href="thanhtoan.php?id_ct=<?php echo $row['id']; ?>">
           Thanh toán
        </a>
    </td>
</tr>
<?php } ?>
</table>

<div class="total">
    Tổng tiền: <?php echo number_format($donHang['tong_tien'],0,',','.'); ?> đ
</div>

<div class="actions">
    <a href="index.php" class="btn btn-xoa">⬅ Mua tiếp</a>
    <a href="thanhtoan.php?id_don=<?php echo $idDonHang; ?>" class="btn btn-pay">
        Thanh toán tất cả
    </a>
</div>

<?php } } ?>

<?php

$rsHistory = mysqli_query($conn, "
    SELECT *
    FROM don_hang
    WHERE id_nguoi_dung = $maTK
      AND id_trang_thai IN (2,3,4)
    ORDER BY ngay_dat DESC
");
?>

<div class="container" style="margin-top:40px;">
    <h1>Lịch sử mua hàng</h1>

<?php if (mysqli_num_rows($rsHistory) == 0) { ?>

    <p class="empty">Chưa có đơn hàng nào.</p>

<?php } else { ?>

<table>
<tr>
    <th>Mã đơn</th>
    <th>Ngày đặt</th>
    <th>Tổng tiền</th>
    <th>Trạng thái</th>
    <th>Chi tiết</th>
</tr>

<?php while ($dh = mysqli_fetch_assoc($rsHistory)) {

 
    if ($dh['id_trang_thai'] == 3) {
        $trangThai = "Chờ xác nhận";
    } elseif ($dh['id_trang_thai'] == 2) {
        $trangThai = "COD – đang giao";
    } else {
        $trangThai = "Đã thanh toán";
    }
?>
<tr>
    <td>DH<?php echo $dh['id']; ?></td>
    <td><?php echo date("d/m/Y H:i", strtotime($dh['ngay_dat'])); ?></td>
    <td><?php echo number_format($dh['tong_tien'],0,',','.'); ?> đ</td>
    <td><?php echo $trangThai; ?></td>
    <td>
        <a class="btn btn-pay"
        href="hoanthanh.php?id=<?php echo $dh['id']; ?>"> Xem</a>
    </td>
</tr>
<?php } ?>

</table>

<?php } ?>
</div>
</div>
</body>
</html>
