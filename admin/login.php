<?php
session_start();

// Nếu đã là admin thì không cần login lại
if (isset($_SESSION['maquyen']) && $_SESSION['maquyen'] == 2) {
    header("Location: index.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "quan_ly_cua_hang_sach");

if (isset($_POST['username']) && isset($_POST['password'])) {

    $hoTen  = mysqli_real_escape_string($conn, $_POST['username']);
    $matKhau = mysqli_real_escape_string($conn, $_POST['password']);

    // CHỈ ADMIN (MaQuyen = 2)
    $sql = "SELECT MaTK, HoTen, MaQuyen 
            FROM tai_khoan
            WHERE HoTen = '$hoTen'
            AND MatKhau = '$matKhau'
            AND MaQuyen = 2";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        $_SESSION['username'] = $row['HoTen'];
        $_SESSION['maquyen']  = $row['MaQuyen'];
        $_SESSION['matk']     = $row['MaTK'];

        header("Location: index.php");
        exit();
    } else {
        $error = "Sai thông tin hoặc bạn không có quyền Admin";
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
        h1{
            text-align: center;
            border-bottom: 1px solid lightgray;
            margin-bottom: 20px;
            padding-bottom: 10px;
            font-size: 20px;
        }
        .box{ margin-bottom: 15px; }
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
        <input type="text" name="username" placeholder="Tên đăng nhập" required>
    </div>

    <div class="box">
        <input type="password" name="password" placeholder="Mật khẩu" required>
    </div>

    <?php
    if (!empty($error)) {
        echo "<p class='warning'>$error</p>";
    }
    ?>

    <div class="submit">
        <input type="submit" value="Đăng nhập">
    </div>
</form>

</body>
</html>
