<?php
include("connect.php");

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$idDon = (int)$_GET['id'];

$rs = mysqli_query($conn, "SELECT * FROM don_hang WHERE id = $idDon");
$don = mysqli_fetch_assoc($rs);

if (!$don) {
    die("Không tìm thấy đơn hàng");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['confirm']) && $don['id_trang_thai'] == 2) {
        mysqli_query($conn,"
            UPDATE don_hang
            SET id_trang_thai = 3
            WHERE id = $idDon AND id_trang_thai = 2
        ");
    }

    if (isset($_POST['ship']) && $don['id_trang_thai'] == 3) {
        // 3 → 4
        mysqli_query($conn,"
            UPDATE don_hang
            SET id_trang_thai = 4
            WHERE id = $idDon AND id_trang_thai = 3
        ");
    }

    if (isset($_POST['done']) && $don['id_trang_thai'] == 4) {
        // 4 → 5
        mysqli_query($conn,"
            UPDATE don_hang
            SET id_trang_thai = 5
            WHERE id = $idDon AND id_trang_thai = 4
        ");
    }

    header("Location: capnhatdonhang.php?id=$idDon");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Cập nhật đơn hàng</title>
<style>
body{
    font-family:Arial;
    background:#f4f4f4;
    padding:40px
}
.box{
    max-width:600px;
    margin:auto;
    background:#fff;
    padding:30px;
    border-radius:10px
}
.btn{
    padding:12px 18px;
    border:none;
    border-radius:6px;
    font-size:16px;
    cursor:pointer;
    margin-top:10px;
    display:inline-block
}
.btn-confirm{background:#007bff;color:#fff}
.btn-ship{background:#28a745;color:#fff}
.btn-done{background:#555;color:#fff}
.btn-back{background:#ccc;color:#000;text-decoration:none}
.status{font-weight:bold}
.actions{margin-top:20px}
</style>
</head>

<body>
<div class="box">

<h2>🧾 Đơn hàng DH<?= $don['id'] ?></h2>

<p><b>Tổng tiền:</b> <?= number_format($don['tong_tien'],0,',','.') ?> đ</p>
<p><b>Địa chỉ giao:</b> <?= htmlspecialchars($don['id_dia_chi'] ?? '—') ?></p>

<p><b>Trạng thái:</b>
<?php
switch ($don['id_trang_thai']) {
    case 2:
        echo "<span class='status' style='color:#ff9800'>Chờ admin xác nhận</span>";
        break;
    case 3:
        echo "<span class='status' style='color:#007bff'>Admin đã xác nhận</span>";
        break;
    case 4:
        echo "<span class='status' style='color:#28a745'>Đang giao</span>";
        break;
    case 5:
        echo "<span class='status' style='color:#555'>Hoàn thành</span>";
        break;
}
?>
</p>

<div class="actions">

<?php if ($don['id_trang_thai'] == 2) { ?>
<form method="post">
    <button class="btn btn-confirm" name="confirm">
        Xác nhận đơn hàng
    </button>
</form>
<?php } ?>

<?php if ($don['id_trang_thai'] == 3) { ?>
<form method="post">
    <button class="btn btn-ship" name="ship">
        Bắt đầu giao hàng
    </button>
</form>
<?php } ?>

<?php if ($don['id_trang_thai'] == 4) { ?>
<form method="post">
    <button class="btn btn-done" name="done">
        Hoàn thành đơn hàng
    </button>
</form>
<?php } ?>

<a href="index.php?page_layout=trangchu" class="btn btn-back">Quay lại danh sách</a>

</div>

</div>
</body>
</html>
