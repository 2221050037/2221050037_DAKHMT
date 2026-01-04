<?php
include("../admin/connect.php");

$keyword = trim($_GET['keyword'] ?? '');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Kết quả tìm kiếm</title>
    <style>
        .search-title{
            font-size:22px;
            margin-bottom:20px;
            font-weight:bold;
        }
        .book-list{
            display:grid;
            grid-template-columns:repeat(auto-fill,minmax(220px,1fr));
            gap:20px;
        }
        .book{
            background:#fff;
            border-radius:8px;
            box-shadow:0 2px 8px rgba(0,0,0,0.15);
            padding:10px;
            text-align:center;
        }
        .book img{
            width:100%;
            height:260px;
            object-fit:cover;
            border-radius:6px;
        }
        .book h4{
            margin:10px 0 5px;
            font-size:16px;
        }
        .book p{
            margin:3px 0;
            font-size:14px;
            color:#555;
        }
        .price{
            color:#e53935;
            font-weight:bold;
            margin-top:5px;
        }
        .btn-buy{
            margin-top:10px;
            padding:8px 12px;
            background:#f2c1b6;
            color:white;
            border:none;
            border-radius:5px;
            cursor:pointer;
            font-weight:bold;
        }
        .btn-buy:hover{
            background:#e39b8f;
        }
    </style>
</head>
<body>

<div class="search-title">
    Kết quả tìm kiếm cho: "<?php echo htmlspecialchars($keyword); ?>"
</div>

<?php
$sql = "
    SELECT 
        s.MaSach,
        s.TuaSach,
        s.HinhAnh,
        s.TacGia,
        s.GiaTri,
        cd.TenChuDe
    FROM sach s
    JOIN chu_de cd ON s.MaCD = cd.MaCD
";

if ($keyword !== '') {
    $safeKey = $conn->real_escape_string($keyword);
    $sql .= "
        WHERE 
            s.TuaSach LIKE '%$safeKey%'
            OR s.TacGia LIKE '%$safeKey%'
            OR cd.TenChuDe LIKE '%$safeKey%'
    ";
}

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo '<div class="book-list">';
    while ($row = $result->fetch_assoc()) {
        ?>
        <div class="book">
            <img src="../uploads/<?php echo $row['HinhAnh']; ?>" alt="">
            <h4><?php echo $row['TuaSach']; ?></h4>
            <p>Tác giả: <?php echo $row['TacGia']; ?></p>
            <p>Chủ đề: <?php echo $row['TenChuDe']; ?></p>
            <div class="price"><?php echo number_format($row['GiaTri']); ?> đ</div>

        
            <form action="index.php?page=giohang" method="post">
                <input type="hidden" name="MaSach" value="<?php echo $row['MaSach']; ?>">
                <input type="hidden" name="SoLuong" value="1">
                <button type="submit" class="btn-buy">Mua hàng</button>
            </form>
        </div>
        <?php
    }
    echo '</div>';
} else {
    echo "<p>Không tìm thấy kết quả phù hợp.</p>";
}
?>

</body>
</html>
