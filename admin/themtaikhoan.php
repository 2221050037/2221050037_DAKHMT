<?php
// ================= XỬ LÝ PHP (PHẢI Ở TRÊN CÙNG) =================
include("connect.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (
        !empty($_POST["so-dien-thoai"]) &&
        !empty($_POST["mat-khau"]) &&
        !empty($_POST["ho-ten"]) &&
        !empty($_POST["ngay-sinh"]) &&
        !empty($_POST["vi-tien"]) &&
        !empty($_POST["ma-quyen"]) &&
        !empty($_FILES["hinh-anh"]["name"])
    ) {

        $soDienThoai = $_POST["so-dien-thoai"];
        $matKhau = $_POST["mat-khau"]; // có thể mã hóa sau
        $hoTen = $_POST["ho-ten"];
        $ngaySinh = $_POST["ngay-sinh"];
        $viTien = $_POST["vi-tien"];
        $maQuyen = $_POST["ma-quyen"];

        /* ========== XỬ LÝ UPLOAD ẢNH ========== */
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = time() . "_" . basename($_FILES["hinh-anh"]["name"]);
        $uploadFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES["hinh-anh"]["tmp_name"], $uploadFile)) {

            $sql = "INSERT INTO tai_khoan
            (SoDienThoai, MatKhau, HoTen, HinhAnh, NgaySinh, ViTien, MaQuyen)
            VALUES
            ('$soDienThoai', '$matKhau', '$hoTen', '$fileName', '$ngaySinh', '$viTien', '$maQuyen')";

            if (mysqli_query($conn, $sql)) {
                mysqli_close($conn);

                // ===== REDIRECT SAU KHI THÊM THÀNH CÔNG =====
                header("Location: index.php?page_layout=taikhoan");
                exit;
            } else {
                $error = "Lỗi thêm dữ liệu";
            }

        } else {
            $error = "Upload ảnh thất bại";
        }

    } else {
        $error = "Vui lòng nhập đầy đủ thông tin";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm tài khoản</title>
    <style>
        *{
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body{
            background: #fff;
        }

        .container{
            width: 40%;
            margin: 40px auto;
            border: 1px solid #000;
            border-radius: 15px;
            padding: 30px;
        }

        h1{
            text-align: center;
            margin-bottom: 20px;
        }

        p{
            margin-bottom: 5px;
            font-weight: bold;
        }

        input{
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
        }

        input[type="submit"]{
            background: #f2f2f2;
            border: 1px solid #000;
            cursor: pointer;
        }

        input[type="submit"]:hover{
            background: #e0e0e0;
        }

        .warning{
            text-align: center;
            color: red;
            font-weight: bold;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <form method="post" enctype="multipart/form-data">
        <h1>Thêm tài khoản</h1>

        <?php if (!empty($error)) echo "<p class='warning'>$error</p>"; ?>

        <p>Số điện thoại</p>
        <input type="number" name="so-dien-thoai">

        <p>Mật khẩu</p>
        <input type="password" name="mat-khau">

        <p>Họ tên</p>
        <input type="text" name="ho-ten">

        <p>Hình ảnh</p>
        <input type="file" name="hinh-anh">

        <p>Ngày sinh</p>
        <input type="date" name="ngay-sinh">

        <p>Ví tiền</p>
        <input type="number" name="vi-tien">

        <p>Mã quyền</p>
        <input type="number" name="ma-quyen">

        <input type="submit" value="Thêm tài khoản">
    </form>
</div>

</body>
</html>
