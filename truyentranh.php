<?php
$conn = new mysqli("localhost", "root", "", "quan_ly_cua_hang_sach");
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Lỗi kết nối CSDL");
}

$maCD = 20;

$sql = "SELECT MaSach, TuaSach, TacGia, HinhAnh, GiaTri, SoLuong
        FROM sach
        WHERE MaCD = ?
        ORDER BY MaSach DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $maCD);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Truyện tranh</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body{
    font-family:Arial, sans-serif;
    background:#f6f6f6;
}

.box-right{
    padding:20px;
}

.snb1{
    display:grid;
    grid-template-columns:repeat(auto-fill, minmax(220px,1fr));
    gap:25px;
}

.khung{
    background:#fff;
    border-radius:10px;
    padding:15px;
    text-align:center;
    transition:0.3s;
}

.khung:hover{
    transform:translateY(-4px);
    box-shadow:0 6px 15px rgba(0,0,0,0.15);
}

.khung img{
    width:150px;
    height:220px;
    object-fit:cover;
    margin-bottom:10px;
}

.ttin1{
    font-weight:bold;
    margin-bottom:5px;
}

.ttin1 small{
    display:block;
    font-weight:normal;
    color:#666;
}

.ttin2{
    color:#d0021b;
    font-weight:bold;
    margin:10px 0;
}

.stock{
    font-size:13px;
    font-weight:bold;
    margin-bottom:10px;
}
.ok{color:#28a745}
.low{color:#ff9800}
.out{color:#d0021b}

.chitiet, .muon{
    display:inline-block;
    padding:8px 16px;
    color:#fff;
    border-radius:6px;
    text-decoration:none;
}

.chitiet{
    background:#28a745;
    margin-right:5px;
}

.muon{
    background:#2d2dfc;
}

.muon.disable{
    background:#ccc;
    cursor:not-allowed;
}
</style>
</head>

<body>

<main>
<div class="box-right">
<h1>Truyện tranh</h1>

<div class="snb1">
<?php if ($result->num_rows > 0): ?>
<?php while ($row = $result->fetch_assoc()): ?>
<div class="khung">

    <img src="./img/product/<?= htmlspecialchars($row['HinhAnh']) ?>"
         alt="<?= htmlspecialchars($row['TuaSach']) ?>">

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

    <a class="chitiet"
       href="chitietsach.php?MaSach=<?= $row['MaSach'] ?>">
       Chi tiết
    </a>

    <?php if ($row['SoLuong'] > 0): ?>
        <a class="muon"
           href="themvaogio.php?MaSach=<?= $row['MaSach'] ?>">
           Mua
        </a>
    <?php else: ?>
        <a class="muon disable">Hết hàng</a>
    <?php endif; ?>

</div>
<?php endwhile; ?>
<?php else: ?>
<p>Không có truyện tranh.</p>
<?php endif; ?>
</div>
</div>
</main>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
