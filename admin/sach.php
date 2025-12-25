<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách các tác phẩm</title>

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

.box a{
    text-decoration: none;
    background: #007bff;
    color: #fff;
    padding: 8px 16px;
    border-radius: 6px;
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
    padding: 10px;
    border: 1px solid #ccc;
    text-align: center;
}

.container th{
    background: #f2f2f2;
}

.container td:nth-child(2),
.container td:nth-child(6){
    text-align: left;
}

.container td img{
    width: 70px;
    border-radius: 4px;
}

.chucnang{
    white-space: nowrap;
}

.btn{
    display: inline-block;
    padding: 6px 12px;
    border-radius: 4px;
    color: #fff;
    text-decoration: none;
    font-size: 13px;
    background: #28a745;
}

.btn:last-child{
    background: #dc3545;
}

.btn:hover{
    opacity: 0.85;
}
</style>
</head>

<body>
<div class="control">
    <h1>Danh sách các tác phẩm</h1>
    <div class="box">
        <a href="index.php?page_layout=themsach">Thêm sách</a>
    </div>
</div>

<table class="container">
    <tr>
        <th>Mã sách</th>
        <th>Mã chủ đề</th>
        <th>Tựa sách</th>
        <th>Hình ảnh</th>
        <th>Tác giả</th>
        <th>Giá trị</th>
        <th>Mô tả</th>
        <th>Chức năng</th>
    </tr>

<?php
include("connect.php");
$sql = "SELECT * FROM sach";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
?>
    <tr>
        <td><?php echo $row['MaSach']; ?></td>
        <td><?php echo $row['MaCD']; ?></td>

        <td>
            <a href="index.php?page_layout=chitietsach&MaSach=<?php echo $row['MaSach']; ?>">
                <?php echo $row['TuaSach']; ?>
            </a>
        </td>

        <td>
            <img src="uploads/<?php echo $row['HinhAnh']; ?>" alt="">
        </td>

        <td><?php echo $row['TacGia']; ?></td>
        <td><?php echo $row['GiaTri']; ?></td>
        <td><?php echo $row['MoTa']; ?></td>

        <td class="chucnang">
            <a class="btn" href="index.php?page_layout=capnhatsach&MaSach=<?php echo $row['MaSach']; ?>">Cập nhật</a>
            <a class="btn" href="xoasach.php?MaSach=<?php echo $row['MaSach']; ?>" 
               onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
        </td>
    </tr>
<?php } ?>
</table>
</body>
</html>
