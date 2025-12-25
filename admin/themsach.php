<?php
include("connect.php");

if (
    !empty($_POST["tua-sach"]) &&
    !empty($_POST["ma-cd"]) &&
    !empty($_POST["tac-gia"]) &&
    !empty($_POST["gia-tri"]) &&
    !empty($_POST["mo-ta"]) &&
    !empty($_FILES["hinh-anh"]["name"])
) {
    $tuaSach = $_POST["tua-sach"];
    $maCD  = $_POST["ma-cd"];
    $tacGia  = $_POST["tac-gia"];
    $giaTri  = $_POST["gia-tri"];
    $moTa    = $_POST["mo-ta"];

    /* XỬ LÝ ẢNH */
    $tenAnh = $_FILES["hinh-anh"]["name"];
    $tmp    = $_FILES["hinh-anh"]["tmp_name"];
    move_uploaded_file($tmp, "uploads/" . $tenAnh);

    $sql = "INSERT INTO sach (TuaSach, HinhAnh, TacGia, GiaTri, MoTa)
            VALUES ('$tuaSach', '$tenAnh', '$tacGia', '$giaTri', '$moTa')";

    mysqli_query($conn, $sql);
    mysqli_close($conn);

    header("location: index.php?page_layout=sach");
    exit();
} 
else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo '<p class="warning">Vui lòng nhập đầy đủ thông tin</p>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sách</title>
    <style>
        *{
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body{
            background: #fff;
        }

        /* Thông báo lỗi */
        .warning{
            text-align: center;
            color: red;
            font-weight: bold;
            margin-top: 20px;
        }

        /* Khung form */
        .container{
            width: 40%;
            margin: 40px auto;
            border: 1px solid #000;
            border-radius: 15px;
            padding: 30px;
        }

        h1{
            margin-bottom: 20px;
        }

        p{
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"]{
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
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
    <form action="index.php?page_layout=themsach" method="post" enctype="multipart/form-data">   
        <h1>Thêm tác phẩm</h1>
        <div>
            <p>Tên sách</p>
            <input type="text" name="tua-sach" placeholder="Tên sách">
        </div>
        <div>
            <p>Mã chủ đề</p>
            <input type="text" name="ma-cd" placeholder="Mã chủ đề">
        </div>
        <div>
            <p>Hình ảnh</p>
            <input type="file" name="hinh-anh" placeholder="Hình ảnh">
        </div>
        <div>
            <p>Tác giả</p>
            <input type="text" name="tac-gia" placeholder="Tác giả">
        </div>
        <div>
            <p>Giá trị</p>
            <input type="number" name="gia-tri" placeholder="Giá trị">
        </div>
        <div>
            <p>Mô tả</p>
            <input type="text" name="mo-ta" placeholder="Mô tả">
        </div>
        
        <div><input type="submit" value="Thêm"></div>

    </form>
    </div>
</body>
</html>