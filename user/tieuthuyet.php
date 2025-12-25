<?php

$conn = new mysqli("localhost", "root", "", "quan_ly_cua_hang_sach");
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Lỗi kết nối CSDL");
}


$maCD = isset($_GET['MaCD']) ? (int)$_GET['MaCD'] : 17;


$sql = "SELECT MaSach, TuaSach, TacGia, HinhAnh, GiaTri 
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
    <title>Tiểu thuyết</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="tieuthuyet.css">
    <style>
        body {
    font-family: Arial, sans-serif;
}

.box-right {
    padding: 20px;
}

.snb1 {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 25px;
}

/* CARD SÁCH */
.khung {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    background: #fff;
    display: flex;
    flex-direction: column;
    align-items: center;
    transition: 0.3s;
}

.khung:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* ẢNH */
.khung img {
    width: 150px;
    height: 220px;
    object-fit: cover;
    margin-bottom: 10px;
}

/* THÔNG TIN */
.ttin {
    width: 100%;
    text-align: center;
}

.ttin1 {
    font-weight: bold;
    margin-bottom: 5px;
}

.ttin1 small {
    font-weight: normal;
    color: #666;
}

.ttin2 {
    color: #d0021b;
    font-weight: bold;
    margin: 8px 0;
}

/* NÚT MUA */
.muon {
    display: inline-block;
    padding: 8px 15px;
    background: #2d2dfc;
    color: white;
    border-radius: 8px;
    text-decoration: none;
    margin-top: 8px;
}

    </style>
</head>
<body>

<main>
    <div class="box-right">
        <h1>Tiểu thuyết</h1>

        <!-- GRID SÁCH -->
        <div class="snb1">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="khung">
                        <img src="./img/<?php echo htmlspecialchars($row['HinhAnh']); ?>"
                             alt="<?php echo htmlspecialchars($row['TuaSach']); ?>">

                        <div class="ttin">
                            <div class="ttin1">
                                <?php echo htmlspecialchars($row['TuaSach']); ?><br>
                                <small><?php echo htmlspecialchars($row['TacGia']); ?></small>
                            </div>

                            <div class="ttin2">
                                <?php echo number_format($row['GiaTri'], 0, ',', '.'); ?>đ
                            </div>

                            <a class="muon" href="chitietsach.php?MaSach=<?php echo $row['MaSach']; ?>">
                                Mua
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Không có sách trong thể loại này.</p>
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
