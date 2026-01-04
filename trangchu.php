<?php
include("connect.php");

$row_tai_khoan = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM tai_khoan"))[0];
$row_sach      = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM sach"))[0];
$row_chu_de    = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM chu_de"))[0];
$row_tacgia    = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM tacgia"))[0];


$sql_donhang_cho = "
    SELECT 
        dh.*,
        GROUP_CONCAT(s.TuaSach SEPARATOR ', ') AS ten_sach
    FROM don_hang dh
    JOIN chi_tiet_don_hang ct ON dh.id = ct.id_don_hang
    JOIN sach s ON ct.id_sach = s.MaSach
    WHERE dh.id_trang_thai IN (2,3,4)
    GROUP BY dh.id
    ORDER BY dh.ngay_dat DESC
";
$donhang_cho = mysqli_query($conn, $sql_donhang_cho);

$sql_donhang_ht = "
    SELECT 
        dh.*,
        GROUP_CONCAT(s.TuaSach SEPARATOR ', ') AS ten_sach
    FROM don_hang dh
    JOIN chi_tiet_don_hang ct ON dh.id = ct.id_don_hang
    JOIN sach s ON ct.id_sach = s.MaSach
    WHERE dh.id_trang_thai = 5
    GROUP BY dh.id
    ORDER BY dh.ngay_dat DESC
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
    margin:0;
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
.card-link{
    flex:1;
    text-decoration:none;
    color:inherit;
}
.card{
    border:1px solid #ddd;
    padding:20px;
    text-align:center;
    background:#f9f9f9;
    border-radius:8px;
    transition:.2s;
}
.card:hover{
    background:#e9f2ff;
    border-color:#007bff;
    transform:translateY(-3px);
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
td.left{
    text-align:left;
}


.btn-fix{
    background:orange;
    color:#000;
    padding:6px 10px;
    border-radius:4px;
    text-decoration:none;
}
.btn-review{
    background:#28a745;
    color:#fff;
    padding:6px 10px;
    border-radius:4px;
    text-decoration:none;
}


.status-wait{color:#ff9800;font-weight:bold}
.status-confirm{color:#007bff;font-weight:bold}
.status-ship{color:#28a745;font-weight:bold}
.status-done{color:#555;font-weight:bold}
</style>
</head>

<body>
<div class="content">

<h2 class="page-title">Tổng quan hệ thống</h2>

<!-- DASHBOARD CLICK -->
<div class="stats-row">
    <a href="index.php?page_layout=taikhoan" class="card-link">
        <div class="card">
            Tài khoản
            <div class="number"><?= $row_tai_khoan ?></div>
        </div>
    </a>

    <a href="index.php?page_layout=sach" class="card-link">
        <div class="card">
            Sách
            <div class="number"><?= $row_sach ?></div>
        </div>
    </a>
</div>

<div class="stats-row">
    <a href="index.php?page_layout=chude" class="card-link">
        <div class="card">
            Chủ đề
            <div class="number"><?= $row_chu_de ?></div>
        </div>
    </a>

    <a href="index.php?page_layout=tacgia" class="card-link">
        <div class="card">
            Tác giả
            <div class="number"><?= $row_tacgia ?></div>
        </div>
    </a>
</div>


<h2 class="page-title">Đơn hàng đang xử lý</h2>

<table>
<tr>
    <th>Mã đơn</th>
    <th>ID người dùng</th>
    <th>Tên sách</th>
    <th>Tổng tiền</th>
    <th>Địa chỉ giao</th>
    <th>Trạng thái</th>
    <th>Ngày đặt</th>
    <th>Chức năng</th>
</tr>

<?php while($row = mysqli_fetch_assoc($donhang_cho)){ ?>
<tr>
    <td>DH<?= $row['id'] ?></td>
    <td><?= $row['id_nguoi_dung'] ?></td>
    <td class="left"><?= htmlspecialchars($row['ten_sach']) ?></td>
    <td><?= number_format($row['tong_tien'],0,',','.') ?> đ</td>
    <td><?= htmlspecialchars($row['id_dia_chi']) ?></td>
    <td>
        <?php
        if ($row['id_trang_thai'] == 2)
            echo '<span class="status-wait">Chờ xác nhận</span>';
        elseif ($row['id_trang_thai'] == 3)
            echo '<span class="status-confirm">Đã xác nhận</span>';
        elseif ($row['id_trang_thai'] == 4)
            echo '<span class="status-ship">Đang giao</span>';
        ?>
    </td>
    <td><?= date("d/m/Y H:i", strtotime($row['ngay_dat'])) ?></td>
    <td>
        <?php if ($row['id_trang_thai'] == 2) { ?>
            <a class="btn-fix" href="capnhatdonhang.php?id=<?= $row['id'] ?>&next=3">Xác nhận</a>
        <?php } elseif ($row['id_trang_thai'] == 3) { ?>
            <a class="btn-fix" href="capnhatdonhang.php?id=<?= $row['id'] ?>&next=4">Giao hàng</a>
        <?php } elseif ($row['id_trang_thai'] == 4) { ?>
            <a class="btn-fix" href="capnhatdonhang.php?id=<?= $row['id'] ?>&next=5">Hoàn thành</a>
        <?php } ?>
    </td>
</tr>
<?php } ?>
</table>


<h2 class="page-title">Đơn hàng đã hoàn thành</h2>

<table>
<tr>
    <th>Mã đơn</th>
    <th>ID người dùng</th>
    <th>Tên sách</th>
    <th>Tổng tiền</th>
    <th>Địa chỉ giao</th>
    <th>Ngày đặt</th>
    <th>Trạng thái</th>
    <th>Đánh giá</th>
</tr>

<?php while($row = mysqli_fetch_assoc($donhang_ht)){ ?>
<tr>
    <td>DH<?= $row['id'] ?></td>
    <td><?= $row['id_nguoi_dung'] ?></td>
    <td class="left"><?= htmlspecialchars($row['ten_sach']) ?></td>
    <td><?= number_format($row['tong_tien'],0,',','.') ?> đ</td>
    <td><?= htmlspecialchars($row['id_dia_chi']) ?></td>
    <td><?= date("d/m/Y H:i", strtotime($row['ngay_dat'])) ?></td>
    <td><span class="status-done">Hoàn thành</span></td>
    <td>
        <a class="btn-review" href="danhgiacuand.php?id_don=<?= $row['id'] ?>">
            Xem
        </a>
    </td>
</tr>
<?php } ?>
</table>

</div>
</body>
</html>
