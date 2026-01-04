<?php
// =======================
// SESSION
// =======================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("../admin/connect.php");

// =======================
// KIỂM TRA ĐĂNG NHẬP
// =======================
if (!isset($_SESSION["MaTK"])) {
    header("Location: ../dangnhap.php");
    exit();
}

$maTK = (int)$_SESSION["MaTK"];

// =======================
// KIỂM TRA THAM SỐ
// =======================
if (!isset($_GET['id_don']) || !isset($_GET['id_sach'])) {
    die("Thiếu thông tin đánh giá");
}

$idDon  = (int)$_GET['id_don'];
$idSach = (int)$_GET['id_sach'];

// =======================
// KIỂM TRA ĐƠN HÀNG CÓ HỢP LỆ & HOÀN THÀNH
// =======================
$checkDon = mysqli_query($conn, "
    SELECT *
    FROM don_hang
    WHERE id = $idDon
      AND id_nguoi_dung = $maTK
      AND id_trang_thai = 5
");

if (mysqli_num_rows($checkDon) == 0) {
    die("Đơn hàng không hợp lệ hoặc chưa hoàn thành");
}

// =======================
// KIỂM TRA ĐÃ ĐÁNH GIÁ CHƯA
// =======================
$checkDG = mysqli_query($conn, "
    SELECT id
    FROM danh_gia_sach
    WHERE id_don_hang = $idDon
      AND id_sach = $idSach
      AND id_nguoi_dung = $maTK
");

if (mysqli_num_rows($checkDG) > 0) {
    die("Bạn đã đánh giá sách này rồi");
}

// =======================
// LẤY TÊN SÁCH
// =======================
$rsSach = mysqli_query($conn, "
    SELECT TuaSach
    FROM sach
    WHERE MaSach = $idSach
");
$sach = mysqli_fetch_assoc($rsSach);

// =======================
// XỬ LÝ GỬI ĐÁNH GIÁ
// =======================
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $soSao   = (int)$_POST['so_sao'];
    $noiDung = mysqli_real_escape_string($conn, $_POST['noi_dung']);

    if ($soSao < 1 || $soSao > 5) {
        $loi = "Số sao không hợp lệ";
    } else {
        mysqli_query($conn, "
            INSERT INTO danh_gia_sach
            (id_sach, id_don_hang, id_nguoi_dung, so_sao, noi_dung)
            VALUES ($idSach, $idDon, $maTK, $soSao, '$noiDung')
        ");

        header("Location: index.php?page=giohang");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Đánh giá sách</title>
<style>
.container{max-width:600px;margin:50px auto;background:#fff;padding:30px;border-radius:10px}
h2{text-align:center}
label{font-weight:bold}
select,textarea,button{width:100%;padding:10px;margin-top:8px}
button{background:#28a745;color:#fff;border:none;border-radius:5px;font-size:16px}
.star{color:gold;font-size:18px}
.error{color:red;text-align:center}
</style>
</head>
<body>

<div class="container">
<h2>Đánh giá sách</h2>

<p><strong>Sách:</strong> <?= htmlspecialchars($sach['TuaSach']) ?></p>

<?php if (!empty($loi)) { ?>
<p class="error"><?= $loi ?></p>
<?php } ?>

<form method="post">
    <label>Số sao:</label>
    <select name="so_sao" required>
        <option value="">-- Chọn --</option>
        <option value="5">⭐⭐⭐⭐⭐ (Rất tốt)</option>
        <option value="4">⭐⭐⭐⭐ (Tốt)</option>
        <option value="3">⭐⭐⭐ (Bình thường)</option>
        <option value="2">⭐⭐ (Kém)</option>
        <option value="1">⭐ (Rất tệ)</option>
    </select>

    <label>Bình luận:</label>
    <textarea name="noi_dung" rows="4" placeholder="Cảm nhận của bạn về sách..." required></textarea>

    <br><br>
    <button type="submit">Gửi đánh giá</button>
</form>
</div>

</body>
</html>
