<?php
session_start();
include("admin/connect.php");

$thongBao = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $soDienThoai = trim($_POST["so_dien_thoai"]);
    $matKhau     = trim($_POST["mat_khau"]);

    if ($soDienThoai == "" || $matKhau == "") {
        $thongBao = "Vui lòng nhập đầy đủ thông tin";
    } else {
        $sql = "
            SELECT *
            FROM tai_khoan
            WHERE SoDienThoai = '$soDienThoai'
              AND MatKhau = '$matKhau'
            LIMIT 1
        ";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);

           
            $_SESSION["MaTK"]       = $row["MaTK"];
            $_SESSION["HoTen"]      = $row["HoTen"];
            $_SESSION["MaQuyen"]    = $row["MaQuyen"];
            $_SESSION["HinhAnh"]    = $row["HinhAnh"];
            $_SESSION["ViTien"]     = $row["ViTien"];

           
            if ($row["MaQuyen"] == 1) {
                header("Location: admin/index.php"); // ADMIN
            } else {
                header("Location: user/index.php"); // USER
            }
            exit();
        } else {
            $thongBao = "Sai số điện thoại hoặc mật khẩu";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>

    <style>
        body{
            background-color: rgba(220, 208, 173, 1);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, Helvetica, sans-serif;
        }

        form{
            width: 360px;
            background-color: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .title{
            text-align: center;
            border-bottom: 1px solid lightgray;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .title p:first-child{
            font-size: 20px;
            font-weight: bold;
        }

        .box{
            margin-bottom: 15px;
        }

        .box input{
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .box input:focus{
            outline: none;
            border-color: rgba(234, 124, 28, 1);
        }

        .submit{
            text-align: center;
            margin-top: 10px;
        }

        .submit input{
            color:white;
            background-color: rgba(234, 124, 28, 1);
            font-weight: bold; 
            padding: 8px 50px; 
            border-radius: 6px; 
            border:none;
            cursor: pointer;
            font-size: 15px;
        }

        .submit input:hover{
            background-color: rgb(220, 110, 20);
        }

        .other{
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }

        .other a{
            text-decoration: none;
            color: rgba(234, 124, 28, 1);
            font-weight: bold;
        }

        .warning{
            color: red;
            text-align: center;
            margin-top: 12px;
        }
    </style>
</head>
<body>

<form method="post">
    <div class="title">
        <p>Đăng nhập</p>
        <p>Chào mừng bạn quay lại</p>
    </div>

    <div class="box">
        <input type="text" name="so_dien_thoai" placeholder="Số điện thoại">
    </div>

    <div class="box">
        <input type="password" name="mat_khau" placeholder="Mật khẩu">
    </div>

    <div class="submit">
        <input type="submit" value="Đăng nhập">
    </div>

    <div class="other">
        <a href="dangky.php">Chưa có tài khoản? Đăng ký</a>
    </div>

    <?php if ($thongBao != "") { ?>
        <div class="warning"><?php echo $thongBao; ?></div>
    <?php } ?>
</form>

</body>
</html>

<!-- <!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>

    <style>
        body{
            background-color: rgba(220, 208, 173, 1);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, Helvetica, sans-serif;
        }

        form{
            width: 360px;
            background-color: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        h1{
            text-align: center;
            border-bottom: 1px solid lightgray;
            margin-bottom: 20px;
            padding-bottom: 10px;
            font-size: 20px;
        }

        .box{
            margin-bottom: 15px;
        }

        .box input{
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .box input:focus{
            outline: none;
            border-color: rgba(234, 124, 28, 1);
        }

        .submit{
            text-align: center;
            margin-top: 10px;
        }

        .submit input{
            color:white;
            background-color: rgba(234, 124, 28, 1);
            font-weight: bold; 
            padding: 8px 50px; 
            border-radius: 6px; 
            border:none;
            cursor: pointer;
            font-size: 15px;
        }

        .submit input:hover{
            background-color: rgb(220, 110, 20);
        }

        .warning{
            color: red;
            text-align: center;
            margin-top: 12px;
            font-weight: bold;
        }
    </style>
</head>

<body>

<form method="post">
    <h1>Đăng nhập</h1>

    <div class="box">
        <input type="text" name="username" placeholder="Tên đăng nhập">
    </div>

    <div class="box">
        <input type="password" name="password" placeholder="Mật khẩu">
    </div>

    <div class="submit">
        <input type="submit" value="Đăng nhập">
    </div>



// if(isset($_POST['username']) && isset($_POST['password'])){
//     $tenDangNhap = $_POST['username'];
//     $matKhau = $_POST['password'];

//     $sql = "SELECT * FROM tai_khoan 
//             WHERE HoTen='$tenDangNhap' AND MatKhau='$matKhau'";
//     $result = mysqli_query($conn, $sql);

//     if(mysqli_num_rows($result) > 0){
//         session_start();
//         $_SESSION["username"] = $tenDangNhap;
//         header('location: index.php');
//         exit();
//     } else {
//         echo "<p class='warning'>Sai thông tin đăng nhập</p>";
//     }
// }
// ?>
</form>

</body>
</html> -->
