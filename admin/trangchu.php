<?php
include("connect.php");


$row_tai_khoan = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM tai_khoan"))[0];
$row_sach      = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM sach"))[0];
$row_chu_de    = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM chu_de"))[0];
$row_tacgia    = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM tacgia"))[0];

$sql_donhang_cho = "
    SELECT * FROM don_hang
    WHERE id_trang_thai IN (2,3)
    ORDER BY ngay_dat DESC
";
$donhang_cho = mysqli_query($conn, $sql_donhang_cho);

$sql_donhang_ht = "
    SELECT * FROM don_hang
    WHERE id_trang_thai = 5
    ORDER BY ngay_dat DESC
";
$donhang_ht = mysqli_query($conn, $sql_donhang_ht);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Tổng quan hệ thống</title>

<style>
body{
    font-family:Arial;
    background:#f4f4f4;
}
.content{
    padding:30px;
    background:#fff;
}
.page-title{
    font-size:26px;
    margin:30px 0;
}
.stats-row{
    display:flex;
    gap:30px;
    margin-bottom:30px;
}
.card{
    flex:1;
    border:1px solid #ddd;
    padding:20px;
    text-align:center;
    background:#f9f9f9;
    border-radius:8px;
}
.number{
    font-size:32px;
    font-weight:bold;
    color:#007bff;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}
th,td{
    border:1px solid #ccc;
    padding:10px;
    text-align:center;
}
th{
    background:#eee;
}

.btn-view{
    background:#007bff;
    color:#fff;
    padding:6px 10px;
    border-radius:4px;
    text-decoration:none;
}
.btn-fix{
    background:orange;
    color:#000;
    padding:6px 10px;
    border-radius:4px;
    text-decoration:none;
}

.status-cod{
    color:#ff9800;
    font-weight:bold;
}
.status-paid{
    color:#28a745;
    font-weight:bold;
}
.status-done{
    color:#007bff;
    font-weight:bold;
}
</style>
</head>

<body>
<div class="content">

<h2 class="page-title">Tổng quan hệ thống</h2>

<div class="stats-row">
    <div class="card">
        Tài khoản
        <div class="number"><?= $row_tai_khoan ?></div>
    </div>
    <div class="card">
        Sách
        <div class="number"><?= $row_sach ?></div>
    </div>
</div>

<div class="stats-row">
    <div class="card">
        Chủ đề
        <div class="number"><?= $row_chu_de ?></div>
    </div>
    <div class="card">
        Tác giả
        <div class="number"><?= $row_tacgia ?></div>
    </div>
</div>


<h2 class="page-title">Đơn hàng chờ xử lý</h2>

<table>
<tr>
    <th>Mã đơn</th>
    <th>ID người dùng</th>
    <th>Tổng tiền</th>
    <th>Trạng thái</th>
    <th>Ngày đặt</th>
    <th>Chức năng</th>
</tr>

<?php while($row = mysqli_fetch_assoc($donhang_cho)){ ?>
<tr>
    <td>DH<?= $row['id'] ?></td>
    <td><?= $row['id_nguoi_dung'] ?></td>
    <td><?= number_format($row['tong_tien']) ?> đ</td>
    <td>
        <?php
        if ($row['id_trang_thai'] == 2) {
            echo '<span class="status-cod">COD – chưa thanh toán</span>';
        } elseif ($row['id_trang_thai'] == 3) {
            echo '<span class="status-paid">Đã thanh toán</span>';
        }
        ?>
    </td>
    <td><?= date("d/m/Y H:i", strtotime($row['ngay_dat'])) ?></td>
    <td>
        <a class="btn-view" href="hoanthanh.php?id=<?= $row['id'] ?>">Xem</a>
        <a class="btn-fix" href="capnhatdonhang.php?id=<?= $row['id'] ?>">
    Xác nhận
</a>
    </td>
</tr>
<?php } ?>
</table>


<h2 class="page-title">Đơn hàng đã giao / hoàn thành</h2>

<table>
<tr>
    <th>Mã đơn</th>
    <th>ID người dùng</th>
    <th>Tổng tiền</th>
    <th>Ngày đặt</th>
    <th>Trạng thái</th>
    <th>Xem</th>
</tr>

<?php while($row = mysqli_fetch_assoc($donhang_ht)){ ?>
<tr>
    <td>DH<?= $row['id'] ?></td>
    <td><?= $row['id_nguoi_dung'] ?></td>
    <td><?= number_format($row['tong_tien']) ?> đ</td>
    <td><?= date("d/m/Y H:i", strtotime($row['ngay_dat'])) ?></td>
    <td><span class="status-done">Đã giao</span></td>
    <td>
        <a class="btn-view" href="hoanthanh.php?id=<?= $row['id'] ?>">Xem</a>
    </td>
</tr>
<?php } ?>
</table>

</div>
</body>
</html>
