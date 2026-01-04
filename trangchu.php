<?php
$conn = new mysqli("localhost", "root", "", "quan_ly_cua_hang_sach");
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Lỗi kết nối CSDL");
}

$theLoai = [
    9  => "Sách giáo khoa",
    17 => "Tiểu thuyết",
    19 => "Trinh thám",
    20 => "Truyện tranh"
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Sách mới nhất</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:Arial,sans-serif;background:#f6f6f6}
main{width:85%;margin:20px auto}

.xuhuong{
    background:#FFD6D1;
    padding:12px 18px;
    margin:20px 0;
    font-weight:bold;
    font-size:18px;
    border-radius:6px;
}

h2{margin:20px 0 10px;font-size:20px}

.snb1{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(200px,1fr));
    gap:20px;
}

.khung{
    background:#fff;
    border-radius:10px;
    padding:12px;
    text-align:center;
    border:1px solid #e0e0e0;
    transition:.3s;
}
.khung:hover{
    transform:translateY(-5px);
    box-shadow:0 6px 18px rgba(0,0,0,.15);
}

.khung img{
    width:100%;
    height:240px;
    object-fit:cover;
    border-radius:6px;
}

.ttin1{font-weight:bold;font-size:14px}
.ttin1 small{display:block;color:#777;font-weight:normal}

.ttin2{color:#d0021b;font-weight:bold;margin:8px 0}

.stock{font-size:13px;font-weight:bold;margin-bottom:8px}
.ok{color:#28a745}
.low{color:#ff9800}
.out{color:#d0021b}

.chitiet,.muon{
    display:inline-block;
    padding:7px 14px;
    border-radius:6px;
    font-size:13px;
    color:#fff;
    text-decoration:none;
}
.chitiet{background:#28a745}
.muon{background:#2d2dfc}
.muon.disable{
    background:#ccc;
    cursor:not-allowed;
}
</style>
</head>

<body>

<section class="hot-books">
<h2>Sách bán chạy</h2>

<div class="snb1">
<?php
$sqlHot = "
    SELECT s.MaSach,s.TuaSach,s.TacGia,s.HinhAnh,s.GiaTri,
           s.SoLuong,
           SUM(ct.so_luong) AS TongBan
    FROM sach s
    JOIN chi_tiet_don_hang ct ON s.MaSach = ct.id_sach
    GROUP BY s.MaSach
    ORDER BY TongBan DESC
    LIMIT 5
";
$resultHot = $conn->query($sqlHot);

if ($resultHot && $resultHot->num_rows > 0):
while ($row = $resultHot->fetch_assoc()):
?>
<div class="khung">
    <img src="./img/product/<?= htmlspecialchars($row['HinhAnh']) ?>">

    <div class="ttin1">
        <?= htmlspecialchars($row['TuaSach']) ?>
        <small><?= htmlspecialchars($row['TacGia']) ?></small>
    </div>

    <div class="ttin2">
        <?= number_format($row['GiaTri'],0,',','.') ?>đ
    </div>

    <div class="stock">
        <?php if ($row['SoLuong'] > 5): ?>
            <span class="ok">Còn <?= $row['SoLuong'] ?> cuốn</span>
        <?php elseif ($row['SoLuong'] > 0): ?>
            <span class="low">Sắp hết (<?= $row['SoLuong'] ?>)</span>
        <?php else: ?>
            <span class="out">Hết hàng</span>
        <?php endif; ?>
    </div>

    <small style="color:#ff5a5f;font-weight:bold">
        Đã bán: <?= (int)$row['TongBan'] ?>
    </small><br><br>

    <a class="chitiet" href="chitietsach.php?MaSach=<?= $row['MaSach'] ?>">
        Chi tiết
    </a>

    <?php if ($row['SoLuong'] > 0): ?>
        <a class="muon" href="themvaogio.php?MaSach=<?= $row['MaSach'] ?>">Mua</a>
    <?php else: ?>
        <a class="muon disable">Hết hàng</a>
    <?php endif; ?>
</div>
<?php endwhile; endif; ?>
</div>
</section>


<main>
<div class="xuhuong">Truyện mới nhất</div>

<?php foreach ($theLoai as $maCD => $tenTL): ?>
<h2><?= $tenTL ?> – Sách mới</h2>

<div class="snb1">
<?php
$sql = "SELECT MaSach,TuaSach,TacGia,HinhAnh,GiaTri,SoLuong
        FROM sach
        WHERE MaCD = ?
        ORDER BY MaSach DESC
        LIMIT 5";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i",$maCD);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()):
?>
<div class="khung">
    <img src="./img/product/<?= htmlspecialchars($row['HinhAnh']) ?>">

    <div class="ttin1">
        <?= htmlspecialchars($row['TuaSach']) ?>
        <small><?= htmlspecialchars($row['TacGia']) ?></small>
    </div>

    <div class="ttin2">
        <?= number_format($row['GiaTri'],0,',','.') ?>đ
    </div>

    <div class="stock">
        <?= $row['SoLuong'] > 0
            ? "Còn {$row['SoLuong']} cuốn"
            : "Hết hàng"; ?>
    </div>

    <a class="chitiet" href="chitietsach.php?MaSach=<?= $row['MaSach'] ?>">Chi tiết</a>

    <?php if ($row['SoLuong'] > 0): ?>
        <a class="muon" href="themvaogio.php?MaSach=<?= $row['MaSach'] ?>">Mua</a>
    <?php else: ?>
        <a class="muon disable">Hết hàng</a>
    <?php endif; ?>
</div>
<?php endwhile; $stmt->close(); ?>
</div>
<?php endforeach; ?>
</main>

</body>
</html>

<?php $conn->close(); ?>
