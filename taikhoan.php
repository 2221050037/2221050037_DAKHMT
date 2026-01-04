<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách các tài khoản</title>
<style>
*{
    box-sizing: border-box;
    font-family: Arial, Helvetica, sans-serif;
}

body{
    background: #fff;
}

.control{
    width: 90%;
    margin: 30px auto 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.control h1{
    margin: 0;
}

.box a{
    text-decoration: none;
    background: #007bff;
    color: #fff;
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 14px;
}

.box a:hover{
    background: #0056b3;
}

.container{
    width: 90%;
    margin: auto;
    border-collapse: collapse;
}

.container th,
.container td{
    padding: 10px 12px;
    border: 1px solid #ccc;
    font-size: 14px;
    vertical-align: middle;
}

.container th{
    background: #f2f2f2;
    text-align: center;
}

.container td{
    text-align: center;
}

.container td:nth-child(2),
.container td:nth-child(4){
    text-align: left;
}


.avatar{
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 6px;
}


.chucnang{
    white-space: nowrap;
}

.btn{
    display: inline-block;
    text-decoration: none;
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 13px;
    color: #fff;
    margin: 2px;
    background: #28a745;
}

.chucnang .btn:last-child{
    background: #dc3545;
}

.btn:hover{
    opacity: 0.85;
}
</style>
</head>

<body>
<div class="control">
    <h1>Danh sách các tài khoản</h1>
    <div class="box">
        <a href="index.php?page_layout=themtaikhoan">Thêm tài khoản</a>
    </div>
</div>

<table class="container">
    <tr>
        <th>Mã TK</th>
        <th>Số điện thoại</th>
        <th>Mật khẩu</th>
        <th>Họ tên</th>
        <th>Ngày sinh</th>
        <th>Mã quyền</th>
        <th>Chức năng</th>
    </tr>

<?php
include("connect.php");

$sql = "SELECT MaTK, SoDienThoai, MatKhau, HoTen, HinhAnh, NgaySinh, ViTien, MaQuyen 
        FROM tai_khoan";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
?>
    <tr>
        <td><?= $row["MaTK"] ?></td>
        <td><?= $row["SoDienThoai"] ?></td>

        
        <td>••••••••</td>

        <td><?= $row["HoTen"] ?></td>

        

        <td><?= date("d/m/Y", strtotime($row["NgaySinh"])) ?></td>
        <td><?= $row["MaQuyen"] ?></td>

        <td class="chucnang">
            <a class="btn" href="index.php?page_layout=capnhattaikhoan&MaTK=<?= $row["MaTK"] ?>">Cập nhật</a>
            <a class="btn" href="xoataikhoan.php?MaTK=<?= $row["MaTK"] ?>" 
               onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
        </td>
    </tr>
<?php } ?>

</table>
</body>
</html>
