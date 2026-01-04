<?php
include("connect.php");

if (!isset($_GET['id_don'])) {
    die("Thiếu mã đơn");
}

$idDon = (int)$_GET['id_don'];

$rs = mysqli_query($conn, "
    SELECT 
        s.TuaSach,
        dg.so_sao,
        dg.noi_dung,
        dg.ngay_danh_gia,
        tk.HoTen
    FROM danh_gia_sach dg
    JOIN sach s ON dg.id_sach = s.MaSach
    JOIN tai_khoan tk ON dg.id_nguoi_dung = tk.MaTK
    WHERE dg.id_don_hang = $idDon
    ORDER BY dg.ngay_danh_gia DESC
");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Đánh giá đơn hàng</title>

<style>
body{
    font-family: Arial, Helvetica, sans-serif;
    background:#f1f3f6;
    margin:0;
    padding:0;
}

/* Khung chính */
.container{
    max-width:900px;
    margin:50px auto;
    background:#ffffff;
    padding:30px 40px;
    border-radius:12px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
}

h2{
    text-align:center;
    margin-bottom:30px;
    color:#333;
}

/* Mỗi đánh giá */
.review{
    border:1px solid #e5e5e5;
    border-radius:10px;
    padding:18px 20px;
    margin-bottom:20px;
    background:#fafafa;
    transition:all 0.2s ease;
}

.review:hover{
    background:#fff;
    box-shadow:0 6px 15px rgba(0,0,0,0.06);
}

/* Tên sách */
.book{
    font-size:16px;
    font-weight:bold;
    color:#0056b3;
    margin-bottom:6px;
}

/* Tên người đánh giá */
.name{
    font-size:14px;
    font-weight:600;
    color:#333;
    margin-bottom:5px;
}

/* Sao */
.star{
    font-size:18px;
    color:#f5b301;
    margin-bottom:8px;
}

/* Nội dung */
.review div:nth-child(4){
    font-size:14px;
    color:#444;
    line-height:1.6;
    margin-bottom:8px;
}

/* Ngày */
.date{
    font-size:12px;
    color:#777;
    text-align:right;
}

/* Nút quay lại */
.back{
    text-align:center;
    margin-top:30px;
}

.back a{
    display:inline-block;
    padding:10px 22px;
    background:#007bff;
    color:#fff;
    border-radius:25px;
    text-decoration:none;
    font-size:14px;
    transition:0.2s;
}

.back a:hover{
    background:#0056b3;
}
</style>

</head>

<body>

<div class="container">
<h2>⭐ Đánh giá đơn hàng #<?= $idDon ?></h2>

<?php if (mysqli_num_rows($rs) == 0) { ?>
    <p>Chưa có đánh giá nào</p>
<?php } ?>

<?php while ($r = mysqli_fetch_assoc($rs)) { ?>
<div class="review">
    <div class="book"><?= htmlspecialchars($r['TuaSach']) ?></div>
    <div class="name"><?= htmlspecialchars($r['HoTen']) ?></div>
    <div class="star"><?= str_repeat("⭐", $r['so_sao']) ?></div>
    <div><?= nl2br(htmlspecialchars($r['noi_dung'])) ?></div>
    <div class="date"><?= date("d/m/Y H:i", strtotime($r['ngay_danh_gia'])) ?></div>
</div>
<?php } ?>

<div class="back">
    <a href="index.php?page_layout=trangchu">Quay lại</a>
</div>

</div>
</body>
</html>
