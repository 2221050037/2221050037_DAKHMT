<?php
include("connect.php");

if (isset($_GET['MaSach'])) {
    $maSach = $_GET['MaSach'];
}

/* Lấy dữ liệu cũ */
$sql = "SELECT * FROM sach WHERE MaSach = '$maSach'";
$result = mysqli_query($conn, $sql);
$Sach = mysqli_fetch_assoc($result);

/* Nếu bấm nút cập nhật */
if (
    !empty($_POST['tua-sach']) &&
    !empty($_POST['ma-cd']) &&
    !empty($_POST['tac-gia']) &&
    !empty($_POST['gia-tri']) &&
    !empty($_POST['mo-ta'])
) {
    $tuaSach = $_POST['tua-sach'];
    $maCD  = $_POST['ma-cd'];
    $tacGia  = $_POST['tac-gia'];
    $giaTri  = $_POST['gia-tri'];
    $moTa    = $_POST['mo-ta'];

    /* XỬ LÝ ẢNH */
    if (!empty($_FILES['hinh-anh']['name'])) {
        $tenAnh = $_FILES['hinh-anh']['name'];
        $tmp    = $_FILES['hinh-anh']['tmp_name'];
        move_uploaded_file($tmp, "uploads/" . $tenAnh);
        $hinhAnh = $tenAnh;
    } else {
        // Không chọn ảnh mới → giữ ảnh cũ
        $hinhAnh = $Sach['HinhAnh'];
    }

    $sql = "UPDATE sach 
            SET TuaSach='$tuaSach',
                MaCD='$maCD',
                HinhAnh='$hinhAnh',
                TacGia='$tacGia',
                GiaTri='$giaTri',
                MoTa='$moTa'
            WHERE MaSach='$maSach'";

    mysqli_query($conn, $sql);
    header("location: index.php?page_layout=sach");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cập nhật</title>
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

    /* Khung form */
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

    /* Input */
    input[type="text"]{
        width: 100%;
        padding: 8px;
    }

    /* Nút cập nhật */
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

    /* Thông báo lỗi */
    .warning{
        text-align: center;
        color: red;
        font-weight: bold;
        margin-top: 20px;
    }
</style>
</head>
<body>
    <div class="container">
        <form action="index.php?page_layout=capnhatsach&MaSach=<?php echo $maSach ?>" method="post" enctype="multipart/form-data">
            <div class="box">
                <p>Tên sách</p>
                <input type="text" name="tua-sach" 
                    value="<?php echo $Sach['TuaSach']; ?>">
            </div>
            <div class="box">
                <p>Mã chủ đề</p>
                <input type="text" name="ma-cd" 
                    value="<?php echo $Sach['MaCD']; ?>">
            </div>
           <div class="box">
                <p>Hình ảnh</p>
                <input type="file" name="hinh-anh">
                <br><br>
                <img src="uploads/<?php echo $Sach['HinhAnh']; ?>" width="120">
        </div>
            <div class="box">
                <p>Tác giả</p>
                <input type="text" name="tac-gia" 
                    value="<?php echo $Sach['TacGia']; ?>">
            </div>
            <div class="box">
                <p>Giá trị</p>
                <input type="text" name="gia-tri" 
                    value="<?php echo $Sach['GiaTri']; ?>">
            </div>
            <div class="box">
                <p>Mô tả</p>
                <input type="text" name="mo-ta" 
                    value="<?php echo $Sach['MoTa']; ?>">
            </div>
            <div class="box">
                <input type="submit" value="Cập nhật">
            </div>
        </form>
    </div>
</body>
</html>