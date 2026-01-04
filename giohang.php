<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("../admin/connect.php");

if (!isset($_SESSION['MaTK'])) {
    header("Location: dangnhap.php");
    exit();
}

$maTK = (int)$_SESSION['MaTK'];

// =======================
// LẤY GIỎ HÀNG HIỆN TẠI
// =======================
$rsCart = mysqli_query($conn, "
    SELECT *
    FROM don_hang
    WHERE id_nguoi_dung = $maTK
      AND id_trang_thai = 1
    ORDER BY id DESC
    LIMIT 1
");
$cart = mysqli_fetch_assoc($rsCart);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Đơn hàng của tôi</title>

<style>
body{background:#f4f6f9;font-family:Arial}
.container{max-width:1100px;margin:30px auto;background:#fff;padding:30px;border-radius:10px}
table{width:100%;border-collapse:collapse}
th,td{border:1px solid #ddd;padding:10px;text-align:center}
th{background:#2d2dfc;color:#fff}
.left{text-align:left}
.btn{padding:6px 12px;border-radius:6px;text-decoration:none;color:#fff;font-size:14px}
.btn-xoa{background:#999}
.btn-pay{background:#ff6b6b}
.btn-rate{background:#28a745}
.btn-view{background:#2d2dfc}
.empty{text-align:center;color:#777;font-size:18px}
</style>
</head>
<body>

<!-- ================= GIỎ HÀNG ================= -->
<div class="container">
<h2>Giỏ hàng hiện tại</h2>

<?php if (!$cart) { ?>
    <p class="empty">Giỏ hàng trống</p>
<?php } else {

$idDon = (int)$cart['id'];

$rsCT = mysqli_query($conn, "
    SELECT ctdh.*, s.TuaSach
    FROM chi_tiet_don_hang ctdh
    JOIN sach s ON ctdh.id_sach = s.MaSach
    WHERE ctdh.id_don_hang = $idDon
");

if (mysqli_num_rows($rsCT) == 0) { ?>
    <p class="empty">Giỏ hàng trống</p>
<?php } else { ?>

<table>
<tr>
    <th>Tên sách</th>
    <th>Giá</th>
    <th>SL</th>
    <th>Thành tiền</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($rsCT)) { ?>
<tr>
    <td class="left"><?= htmlspecialchars($row['TuaSach']) ?></td>
    <td><?= number_format($row['gia'],0,',','.') ?> đ</td>
    <td><?= $row['so_luong'] ?></td>
    <td><?= number_format($row['gia']*$row['so_luong'],0,',','.') ?> đ</td>
</tr>
<?php } ?>
</table>

<p style="text-align:right;font-size:18px;font-weight:bold">
    Tổng tiền: <?= number_format($cart['tong_tien'],0,',','.') ?> đ
</p>

<p style="text-align:right">
    <a href="xoadonhang.php?id_don=<?= $idDon ?>"
       class="btn btn-xoa"
       onclick="return confirm('Xóa toàn bộ giỏ hàng?')">
       Xóa giỏ hàng
    </a>

    <a href="thanhtoan.php?id_don=<?= $idDon ?>"
       class="btn btn-pay">
       ✔ Đặt hàng
    </a>
</p>

<?php } } ?>
</div>

<!-- ================= LỊCH SỬ ĐƠN HÀNG ================= -->
<?php
$rsHistory = mysqli_query($conn, "
    SELECT *
    FROM don_hang
    WHERE id_nguoi_dung = $maTK
      AND id_trang_thai IN (2,3,4,5)
    ORDER BY ngay_dat DESC
");
?>

<div class="container">
<h2>Lịch sử đơn hàng</h2>

<?php if (mysqli_num_rows($rsHistory) == 0) { ?>
    <p class="empty">Chưa có đơn hàng nào.</p>
<?php } else { ?>

<table>
<tr>
    <th>Mã đơn</th>
    <th>Ngày đặt</th>
    <th>Tổng tiền</th>
    <th>Trạng thái</th>
    <th>Sách</th>
    <th>Đánh giá</th>
</tr>

<?php while ($don = mysqli_fetch_assoc($rsHistory)) {

switch ($don['id_trang_thai']) {
    case 2: $tt = "Chờ xác nhận"; break;
    case 3: $tt = "Đã xác nhận"; break;
    case 4: $tt = "Đang giao"; break;
    case 5: $tt = "Hoàn thành"; break;
    default: $tt = "Không rõ";
}

// LẤY SÁCH TRONG ĐƠN
$rsSach = mysqli_query($conn, "
    SELECT ctdh.id_sach, s.TuaSach
    FROM chi_tiet_don_hang ctdh
    JOIN sach s ON ctdh.id_sach = s.MaSach
    WHERE ctdh.id_don_hang = {$don['id']}
");
?>

<?php while ($sach = mysqli_fetch_assoc($rsSach)) {

// KIỂM TRA ĐÃ ĐÁNH GIÁ CHƯA
$checkDG = mysqli_query($conn, "
    SELECT id
    FROM danh_gia_sach
    WHERE id_don_hang = {$don['id']}
      AND id_sach = {$sach['id_sach']}
      AND id_nguoi_dung = $maTK
");
$daDanhGia = mysqli_num_rows($checkDG) > 0;
?>
<tr>
    <td>DH<?= $don['id'] ?></td>
    <td><?= date("d/m/Y H:i", strtotime($don['ngay_dat'])) ?></td>
    <td><?= number_format($don['tong_tien'],0,',','.') ?> đ</td>
    <td><?= $tt ?></td>
    <td class="left"><?= htmlspecialchars($sach['TuaSach']) ?></td>
    <td>
        <?php if ($don['id_trang_thai'] == 5) { ?>

            <?php if ($daDanhGia) { ?>
                <a class="btn btn-view"
                   href="xemdanhgia.php?id_don=<?= $don['id'] ?>&id_sach=<?= $sach['id_sach'] ?>">
                   Xem đánh giá
                </a>
            <?php } else { ?>
                <a class="btn btn-rate"
                   href="danhgia.php?id_don=<?= $don['id'] ?>&id_sach=<?= $sach['id_sach'] ?>">
                   Đánh giá
                </a>
            <?php } ?>

        <?php } else { ?>
            <span style="color:#888">Chưa thể đánh giá</span>
        <?php } ?>
    </td>
</tr>
<?php } } ?>
</table>

<?php } ?>
</div>

</body>
</html>
