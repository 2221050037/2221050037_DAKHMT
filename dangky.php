<?php
session_start();
include("admin/connect.php");

$thongBao = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $hoTen       = trim($_POST["ho_ten"]);
    $soDienThoai = trim($_POST["so_dien_thoai"]);
    $matKhau     = trim($_POST["mat_khau"]);
    $ngaySinh    = $_POST["ngay_sinh"];

   
    $viTien  = 0;
    $maQuyen = 2; // USER
    $hinhAnh = "default.png";

   
    if ($hoTen == "" || $soDienThoai == "" || $matKhau == "" || $ngaySinh == "") {
        $thongBao = "Vui lòng nhập đầy đủ thông tin";
    } else {

       
        $check = "
            SELECT MaTK 
            FROM tai_khoan 
            WHERE SoDienThoai = '$soDienThoai'
            LIMIT 1
        ";
        $result = mysqli_query($conn, $check);

        if (!$result) {
            $thongBao = "Lỗi SQL: " . mysqli_error($conn);
        }
        else if (mysqli_num_rows($result) > 0) {
            $thongBao = "Số điện thoại đã tồn tại";
        }
        else {

            
            $sql = "
                INSERT INTO tai_khoan
                (SoDienThoai, MatKhau, HoTen, HinhAnh, NgaySinh, ViTien, MaQuyen)
                VALUES
                ('$soDienThoai', '$matKhau', '$hoTen', '$hinhAnh', '$ngaySinh', $viTien, $maQuyen)
            ";

            if (mysqli_query($conn, $sql)) {
                echo "<script>
                        alert('Đăng ký thành công!');
                        window.location='dangnhap.php';
                      </script>";
                exit();
            } else {
                $thongBao = "Lỗi SQL: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký</title>

    <style>
        body{
            background-color: rgba(220,208,173,1);
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            font-family:Arial;
        }
        form{
            width:380px;
            background:#fff;
            padding:25px;
            border-radius:12px;
            box-shadow:0 4px 12px rgba(0,0,0,0.15);
        }
        .box{ margin-bottom:15px; }
        input{
            width:100%;
            padding:10px;
            border-radius:6px;
            border:1px solid #ccc;
        }
        .submit input{
            background:rgba(234,124,28,1);
            color:white;
            font-weight:bold;
            border:none;
            cursor:pointer;
        }
        .warning{
            color:red;
            text-align:center;
            margin-top:10px;
        }
        .other{
            text-align:center;
            margin-top:10px;
        }
    </style>
</head>

<body>

<form method="post">
    <h2 style="text-align:center">Đăng ký</h2>

    <div class="box">
        <input type="text" name="ho_ten" placeholder="Họ tên">
    </div>

    <div class="box">
        <input type="text" name="so_dien_thoai" placeholder="Số điện thoại">
    </div>

    <div class="box">
        <input type="password" name="mat_khau" placeholder="Mật khẩu">
    </div>

    <div class="box">
        <input type="date" name="ngay_sinh">
    </div>

    <div class="submit">
        <input type="submit" value="Đăng ký">
    </div>

    <div class="other">
        <a href="dangnhap.php">Đã có tài khoản? Đăng nhập</a>
    </div>

    <?php if ($thongBao != "") { ?>
        <div class="warning"><?= $thongBao ?></div>
    <?php } ?>
</form>

</body>
</html>
