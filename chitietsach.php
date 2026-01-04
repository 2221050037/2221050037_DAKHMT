<?php
$conn = new mysqli("localhost", "root", "", "quan_ly_cua_hang_sach");
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Lỗi kết nối CSDL");
}

if (!isset($_GET['MaSach'])) {
    die("Không có mã sách");
}

$maSach = (int)$_GET['MaSach'];


$sql = "SELECT TuaSach, HinhAnh, TacGia, GiaTri, MoTa, SoLuong
        FROM sach 
        WHERE MaSach = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $maSach);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Không tìm thấy sách");
}

$sach = $result->fetch_assoc();

$sqlDanhGia = "
    SELECT so_sao, noi_dung, ngay_danh_gia
    FROM danh_gia_sach
    WHERE id_sach = ?
    ORDER BY ngay_danh_gia DESC
";
$stmtDG = $conn->prepare($sqlDanhGia);
$stmtDG->bind_param("i", $maSach);
$stmtDG->execute();
$dsDanhGia = $stmtDG->get_result();


$sqlTB = "
    SELECT AVG(so_sao) AS tb_sao, COUNT(*) AS tong
    FROM danh_gia_sach
    WHERE id_sach = ?
";
$stmtTB = $conn->prepare($sqlTB);
$stmtTB->bind_param("i", $maSach);
$stmtTB->execute();
$tb = $stmtTB->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($sach['TuaSach']) ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body{
    font-family: Arial, sans-serif;
    background:#f5f5f5;
    margin:0;
}
.container{
    max-width:900px;
    margin:40px auto;
    background:#fff;
    padding:25px;
    border-radius:10px;
    box-shadow:0 6px 20px rgba(0,0,0,0.15);
}
.book{
    display:flex;
    gap:30px;
}
.book img{
    width:260px;
    height:380px;
    object-fit:cover;
    border-radius:8px;
    border:1px solid #ddd;
}
.info h1{
    margin-top:0;
}
.author{
    color:#666;
    margin-bottom:10px
}
.price{
    font-size:22px;
    color:#d0021b;
    font-weight:bold;
    margin-bottom:10px;
}
.stock{
    margin-bottom:15px;
    font-weight:bold;
}
.stock-ok{color:#28a745}
.stock-low{color:#ff9800}
.stock-out{color:#d0021b}

.desc{
    line-height:1.6;
    white-space:pre-line;
}
.actions a{
    display:inline-block;
    padding:12px 22px;
    color:#fff;
    text-decoration:none;
    border-radius:6px;
    margin-right:10px;
}
.buy{background:#2d2dfc}
.back{background:#999}

/* ===== ĐÁNH GIÁ ===== */
.review-box{
    margin-top:40px;
    border-top:1px solid #eee;
    padding-top:30px;
}
.review-title{
    font-size:22px;
    margin-bottom:10px;
}
.avg{
    font-size:18px;
    margin-bottom:20px;
}
.review{
    border-bottom:1px solid #eee;
    padding:15px 0;
}
.star{
    color:gold;
    font-size:16px;
}
.date{
    font-size:13px;
    color:#777;
}
.no-review{
    color:#777;
    font-style:italic;
}
</style>
</head>

<body>

<div class="container">

    <div class="book">
        <img src="./img/product/<?= htmlspecialchars($sach['HinhAnh']) ?>">

        <div class="info">
            <h1><?= htmlspecialchars($sach['TuaSach']) ?></h1>

            <div class="author">
                Tác giả: <?= htmlspecialchars($sach['TacGia']) ?>
            </div>

            <div class="price">
                <?= number_format($sach['GiaTri'],0,',','.') ?> đ
            </div>

            <!-- ===== SỐ LƯỢNG ===== -->
            <div class="stock">
                <?php if ($sach['SoLuong'] > 5) { ?>
                    <span class="stock-ok">
                        Còn <?= $sach['SoLuong'] ?> cuốn
                    </span>
                <?php } elseif ($sach['SoLuong'] > 0) { ?>
                    <span class="stock-low">
                        Sắp hết hàng (<?= $sach['SoLuong'] ?> cuốn)
                    </span>
                <?php } else { ?>
                    <span class="stock-out">
                        Hết hàng
                    </span>
                <?php } ?>
            </div>

            <div class="desc">
                <?= nl2br(htmlspecialchars($sach['MoTa'])) ?>
            </div>

            <div class="actions">
                <?php if ($sach['SoLuong'] > 0) { ?>
                    <a href="themvaogio.php?MaSach=<?= $maSach ?>" class="buy">
                        Thêm vào giỏ
                    </a>
                <?php } else { ?>
                    <a href="javascript:void(0)" class="buy" style="background:#ccc;cursor:not-allowed">
                        Tạm hết hàng
                    </a>
                <?php } ?>

                <a href="javascript:history.back()" class="back">Quay lại</a>
            </div>
        </div>
    </div>

   
    <div class="review-box">
        <div class="review-title">⭐ Đánh giá của người mua</div>

        <?php if ($tb['tong'] > 0) { ?>
            <div class="avg">
                Trung bình:
                <span class="star">
                    <?= number_format($tb['tb_sao'],1) ?> / 5 ⭐
                </span>
                (<?= $tb['tong'] ?> đánh giá)
            </div>
        <?php } ?>

        <?php if ($dsDanhGia->num_rows > 0) { ?>
            <?php while ($dg = $dsDanhGia->fetch_assoc()) { ?>
                <div class="review">
                    <div class="star">
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            echo ($i <= $dg['so_sao']) ? "⭐" : "☆";
                        }
                        ?>
                    </div>

                    <p><?= nl2br(htmlspecialchars($dg['noi_dung'])) ?></p>

                    <div class="date">
                        <?= date("d/m/Y", strtotime($dg['ngay_danh_gia'])) ?>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p class="no-review">Chưa có đánh giá nào cho sách này.</p>
        <?php } ?>
    </div>

</div>

</body>
</html>

<?php
$stmt->close();
$stmtDG->close();
$stmtTB->close();
$conn->close();
?>
