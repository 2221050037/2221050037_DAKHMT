<?php

$conn = new mysqli("localhost", "root", "", "quan_ly_cua_hang_sach");
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Lỗi kết nối CSDL");
}

$maCD = 9;


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
    <title>Sách giáo khoa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f6f6f6;
        }

        .box-right {
            padding: 20px;
        }

        .box-right h1 {
            margin-bottom: 20px;
        }

        .snb1 {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 25px;
        }

        .khung {
            background: #fff;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            transition: 0.3s;
        }

        .khung:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.15);
        }

        .khung img {
            width: 150px;
            height: 220px;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .ttin1 {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .ttin1 small {
            display: block;
            font-weight: normal;
            color: #666;
        }

        .ttin2 {
            color: #d0021b;
            font-weight: bold;
            margin: 10px 0;
        }

        .muon {
            display: inline-block;
            padding: 8px 16px;
            background: #2d2dfc;
            color: #fff;
            border-radius: 6px;
            text-decoration: none;
            transition: 0.2s;
        }

        .muon:hover {
            background: #1b1bd8;
        }
    </style>
</head>

<body>

<main>
    <div class="box-right">
        <h1>Sách giáo khoa</h1>

        <div class="snb1">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="khung">
                        <img src="./img/product/<?php echo htmlspecialchars($row['HinhAnh']); ?>"
                             alt="<?php echo htmlspecialchars($row['TuaSach']); ?>">

                        <div class="ttin1">
                            <?php echo htmlspecialchars($row['TuaSach']); ?>
                            <small><?php echo htmlspecialchars($row['TacGia']); ?></small>
                        </div>

                        <div class="ttin2">
                            <?php echo number_format($row['GiaTri'], 0, ',', '.'); ?>đ
                        </div>

                       
                        <a class="muon"
                           href="themvaogio.php?MaSach=<?php echo $row['MaSach']; ?>">
                            Mua
                        </a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Không có sách giáo khoa.</p>
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
