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

        
        $laAdmin = isset($_POST['login_admin']);

        $sql = "
            SELECT *
            FROM tai_khoan
            WHERE SoDienThoai = '$soDienThoai'
              AND MatKhau = '$matKhau'
        ";

        
        if ($laAdmin) {
            $sql .= " AND MaQuyen = 1";
        } else {
            $sql .= " AND MaQuyen <> 1";
        }

        $sql .= " LIMIT 1";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {

            $row = mysqli_fetch_assoc($result);

            $_SESSION["MaTK"]    = $row["MaTK"];
            $_SESSION["HoTen"]   = $row["HoTen"];
            $_SESSION["MaQuyen"] = $row["MaQuyen"];
            $_SESSION["ViTien"]  = $row["ViTien"];

            if ($laAdmin) {
                header("Location: admin/index.php");
            } else {
                header("Location: user/index.php");
            }
            exit();

        } else {
            $thongBao = $laAdmin
                ? "Tài khoản này không phải ADMIN"
                : "Sai số điện thoại hoặc mật khẩu";
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
    background:#e9dfc3;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    font-family:Arial;
}

form{
    width:360px;
    background:#fff;
    border-radius:14px;
    padding:25px;
    box-shadow:0 5px 15px rgba(0,0,0,.2);
}

h2{
    text-align:center;
    margin-bottom:20px;
}

input{
    width:100%;
    padding:10px;
    margin:10px 0;
    border-radius:6px;
    border:1px solid #ccc;
}

.buttons{
    display:flex;
    gap:10px;
    margin-top:15px;
}

button{
    flex:1;
    padding:10px;
    border:none;
    color:#fff;
    font-weight:bold;
    border-radius:6px;
    cursor:pointer;
}

.user{
    background:#28a745;
}

.admin{
    background:#dc3545;
}

.warning{
    color:red;
    text-align:center;
    margin-top:12px;
}
</style>
</head>

<body>

<form method="post">
    <h2>Đăng nhập hệ thống</h2>

    <input type="text" name="so_dien_thoai" placeholder="Số điện thoại">
    <input type="password" name="mat_khau" placeholder="Mật khẩu">

    <div class="buttons">
        <button class="user" type="submit" name="login_user">
            User
        </button>

        <button class="admin" type="submit" name="login_admin">
            Admin
        </button>
    </div>

    <?php if ($thongBao != "") { ?>
        <div class="warning"><?= $thongBao ?></div>
    <?php } ?>
</form>

</body>
</html>
