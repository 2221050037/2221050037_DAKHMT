<?php
include("connect.php");

if (isset($_GET['MaSach'])) {
    $maSach = $_GET['MaSach'];
}


$sql = "SELECT * FROM sach WHERE MaSach = '$maSach'";
$result = mysqli_query($conn, $sql);
$Sach = mysqli_fetch_assoc($result);


if (
    !empty($_POST['tua-sach']) &&
    !empty($_POST['ma-cd']) &&
    !empty($_POST['tac-gia']) &&
    !empty($_POST['gia-tri']) &&
    !empty($_POST['mo-ta']) &&
    isset($_POST['so-luong'])
) {
    $tuaSach = $_POST['tua-sach'];
    $maCD    = $_POST['ma-cd'];
    $tacGia  = $_POST['tac-gia'];
    $giaTri  = $_POST['gia-tri'];
    $moTa    = $_POST['mo-ta'];
    $soLuong = $_POST['so-luong'];

 
    if (!empty($_FILES['hinh-anh']['name'])) {
        $tenAnh = $_FILES['hinh-anh']['name'];
        $tmp    = $_FILES['hinh-anh']['tmp_name'];
        move_uploaded_file($tmp, "uploads/" . $tenAnh);
        $hinhAnh = $tenAnh;
    } else {
        $hinhAnh = $Sach['HinhAnh'];
    }

    
    $sql = "UPDATE sach 
            SET TuaSach='$tuaSach',
                MaCD='$maCD',
                HinhAnh='$hinhAnh',
                TacGia='$tacGia',
                GiaTri='$giaTri',
                SoLuong='$soLuong',
                MoTa='$moTa'
            WHERE MaSach='$maSach'";

    mysqli_query($conn, $sql);
    header("location: index.php?page_layout=sach");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cập nhật sách</title>
<style>
*{
    box-sizing: border-box;
    font-family: Arial, Helvetica, sans-serif;
}
body{
    background: #fff;
}
p{
    font-weight: bold;
    margin: 5px 0;
}
h1{
    margin-bottom: 15px;
}
.container{
    width: 40%;
    margin: 40px auto;
    border: 1px solid #000;
    border-radius: 15px;
    padding: 25px;
    display: flex;
    justify-content: center;
}
form{
    width: 100%;
}
.box{
    margin-bottom: 15px;
}
input[type="text"],
input[type="number"]{
    width: 100%;
    padding: 8px;
}
input[type="submit"]{
    width: 100%;
    padding: 8px;
    border: 1px solid #000;
    background: #f2f2f2;
    cursor: pointer;
}
input[type="submit"]:hover{
    background: #e0e0e0;
}
</style>
</head>

<body>
<div class="container">
<form action="index.php?page_layout=capnhatsach&MaSach=<?= $maSach ?>" 
      method="post" enctype="multipart/form-data">

    <div class="box">
        <p>Tên sách</p>
        <input type="text" name="tua-sach" value="<?= $Sach['TuaSach']; ?>">
    </div>

    <div class="box">
        <p>Mã chủ đề</p>
        <input type="text" name="ma-cd" value="<?= $Sach['MaCD']; ?>">
    </div>

    <div class="box">
        <p>Hình ảnh</p>
        <input type="file" name="hinh-anh">
        <br><br>
        <img src="uploads/<?= $Sach['HinhAnh']; ?>" width="120">
    </div>

    <div class="box">
        <p>Tác giả</p>
        <input type="text" name="tac-gia" value="<?= $Sach['TacGia']; ?>">
    </div>

    <div class="box">
        <p>Giá trị</p>
        <input type="text" name="gia-tri" value="<?= $Sach['GiaTri']; ?>">
    </div>

   
    <div class="box">
        <p>Số lượng</p>
        <input type="number" name="so-luong" min="0" value="<?= $Sach['SoLuong']; ?>">
    </div>

    <div class="box">
        <p>Mô tả</p>
        <input type="text" name="mo-ta" value="<?= $Sach['MoTa']; ?>">
    </div>

    <div class="box">
        <input type="submit" value="Cập nhật">
    </div>

</form>
</div>
</body>
</html>
