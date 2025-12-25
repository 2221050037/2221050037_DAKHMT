<?php
include("connect.php");

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$idDon = (int)$_GET['id'];

/* ===== LẤY THÔNG TIN ĐƠN ===== */
$rs = mysqli_query($conn, "SELECT * FROM don_hang WHERE id = $idDon");
$don = mysqli_fetch_assoc($rs);

if (!$don) {
    echo "Không tìm thấy đơn hàng";
    exit();
}

/* ===== XỬ LÝ ACTION ===== */
if (isset($_POST['xacnhan_don'])) {
    // COD → admin xác nhận đơn (chuyển sang đã thanh toán)
    mysqli_query($conn, "
        UPDATE don_hang
        SET id_trang_thai = 3
        WHERE id = $idDon
    ");
    header("Location: index.php");
    exit();
}

if (isset($_POST['xacnhan_thanhtoan'])) {
    // Admin xác nhận đã thu tiền / hoàn tất
    mysqli_query($conn, "
        UPDATE don_hang
        SET id_trang_thai = 5
        WHERE id = $idDon
    ");
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Cập nhật đơn hàng</title>
<style>
body{font-family:Arial;background:#f4f4f4;padding:40px}
.box{max-width:600px;margin:auto;background:#fff;padding:30px;border-radius:10px}
.btn{padding:10px 16px;border:none;border-radius:5px;font-size:15px;cursor:pointer}
.btn-confirm{background:#28a745;color:#fff}
.btn-done{background:#007bff;color:#fff}
</style>
</head>

<body>
<div class="box">
<h2>🧾 Đơn hàng DH<?= $don['id'] ?></h2>

<p><b>Tổng tiền:</b> <?= number_format($don['tong_tien']) ?> đ</p>

<p><b>Trạng thái hiện tại:</b>
<?php
if ($don['id_trang_thai'] == 2) echo "💰 COD – chưa thanh toán";
elseif ($don['id_trang_thai'] == 3) echo "✅ Đã thanh toán";
elseif ($don['id_trang_thai'] == 5) echo "✔️ Hoàn thành";
?>
</p>

<form method="post">

<?php if ($don['id_trang_thai'] == 2) { ?>
    <button class="btn btn-confirm" name="xacnhan_don">
        ✔️ Xác nhận đơn hàng (đã thu tiền / duyệt COD)
    </button>
<?php } ?>

<?php if ($don['id_trang_thai'] == 3) { ?>
    <button class="btn btn-done" name="xacnhan_thanhtoan">
        🚚 Xác nhận đã giao / hoàn tất
    </button>
<?php } ?>

</form>
</div>
</body>
</html>
