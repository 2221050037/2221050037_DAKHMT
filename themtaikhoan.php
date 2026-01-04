<?php

include("connect.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (
        !empty($_POST["mat-khau"]) &&
        !empty($_POST["ho-ten"]) &&
        !empty($_POST["ngay-sinh"]) &&
        !empty($_POST["ma-quyen"])
    ) {

       
        $soDienThoai = $_POST["so-dien-thoai"] ?? "";
        $matKhau     = $_POST["mat-khau"];
        $hoTen       = $_POST["ho-ten"];
        $ngaySinh    = $_POST["ngay-sinh"];
        $maQuyen     = $_POST["ma-quyen"];

        
        $viTien = 0;

        $sql = "INSERT INTO tai_khoan
                (SoDienThoai, MatKhau, HoTen, NgaySinh, MaQuyen)
                VALUES
                ('$soDienThoai', '$matKhau', '$hoTen', '$ngaySinh', $maQuyen)";

        if (mysqli_query($conn, $sql)) {
            header("Location: index.php?page_layout=taikhoan");
            exit;
        } else {
            $error = "Lỗi SQL: " . mysqli_error($conn);
        }

    } else {
        $error = "Vui lòng nhập đầy đủ thông tin bắt buộc";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Thêm tài khoản</title>

<style>
*{box-sizing:border-box;font-family:Arial}
.container{
    width:40%;
    margin:40px auto;
    border:1px solid #000;
    border-radius:15px;
    padding:30px;
}
h1{text-align:center}
p{font-weight:bold;margin-bottom:5px}
input{
    width:100%;
    padding:8px;
    margin-bottom:15px
}
input[type=submit]{cursor:pointer}
.warning{
    text-align:center;
    color:red;
    font-weight:bold;
    margin-bottom:15px
}
</style>
</head>

<body>

<div class="container">
<form method="post">

<h1>Thêm tài khoản</h1>

<?php if (!empty($error)) echo "<p class='warning'>$error</p>"; ?>

<p>Số điện thoại (không bắt buộc)</p>
<input type="text" name="so-dien-thoai">

<p>Họ tên (dùng để đăng nhập)</p>
<input type="text" name="ho-ten" required>

<p>Mật khẩu</p>
<input type="password" name="mat-khau" required>

<p>Ngày sinh</p>
<input type="date" name="ngay-sinh" required>

<p>Mã quyền (1 = Admin, 2 = User)</p>
<input type="number" name="ma-quyen" required>

<input type="submit" value="Thêm tài khoản">

</form>
</div>

</body>
</html>
