<?php
// index.php đã session_start rồi → KHÔNG gọi lại
include("../admin/connect.php");

if (!isset($_SESSION["MaTK"])) {
    header("Location: ../dangnhap.php");
    exit();
}

$maTK = $_SESSION["MaTK"];

$sql = "SELECT * FROM tai_khoan WHERE MaTK = $maTK";
$user = mysqli_fetch_assoc(mysqli_query($conn, $sql));
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Thông tin cá nhân</title>
<style>
body{font-family:Arial;background:#f5f5f5;padding:30px}
.box{max-width:500px;margin:auto;background:#fff;padding:20px;border-radius:8px}
h2{text-align:center}
p{margin:10px 0}
img{width:120px;border-radius:6px}
.btns{display:flex;gap:10px;margin-top:20px}
a{flex:1;text-align:center;padding:10px;background:#ff8c7a;color:white;text-decoration:none;border-radius:6px}
.back{background:#ccc;color:#000}
</style>
</head>
<body>

<div class="box">
<h2>Thông tin cá nhân</h2>

<p><b>Họ tên:</b> <?= $user['HoTen'] ?></p>
<p><b>Số điện thoại:</b> <?= $user['SoDienThoai'] ?></p>
<p><b>Ngày sinh:</b> <?= date("d/m/Y", strtotime($user['NgaySinh'])) ?></p>
<p><b>Ví tiền:</b> <?= number_format($user['ViTien']) ?> đ</p>
<p><b>Quyền:</b> <?= $user['MaQuyen']==1?'Admin':'User' ?></p>

<p><b>Hình ảnh:</b><br>
<img src="../uploads/<?= $user['HinhAnh'] ?>">
</p>

<div class="btns">
    <a href="index.php" class="back">⬅ Quay lại</a>
    <a href="capnhatthongtincanhan.php">✏ Cập nhật</a>
</div>

</div>

</body>
</html>
