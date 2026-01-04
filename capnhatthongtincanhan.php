<?php
session_start();

include("../admin/connect.php");

if (!isset($_SESSION["MaTK"])) {
    header("Location: ../dangnhap.php");
    exit();
}

$maTK = (int)$_SESSION["MaTK"];
$thongBao = "";


$sql = "SELECT * FROM tai_khoan WHERE MaTK = $maTK";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    die("Không tìm thấy tài khoản");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sdt      = trim($_POST["sdt"]);
    $hoTen    = trim($_POST["hoten"]);
    $ngaySinh = $_POST["ngaysinh"];
    $matKhau  = trim($_POST["matkhau"]);

    if ($sdt == "" || $hoTen == "" || $ngaySinh == "") {
        $thongBao = "Vui lòng nhập đầy đủ thông tin";
    } else {

        
        if ($matKhau != "") {
            $sqlUpdate = "
                UPDATE tai_khoan SET
                    SoDienThoai = '$sdt',
                    MatKhau     = '$matKhau',
                    HoTen       = '$hoTen',
                    NgaySinh    = '$ngaySinh'
                WHERE MaTK = $maTK
            ";
        } 
        
        else {
            $sqlUpdate = "
                UPDATE tai_khoan SET
                    SoDienThoai = '$sdt',
                    HoTen       = '$hoTen',
                    NgaySinh    = '$ngaySinh'
                WHERE MaTK = $maTK
            ";
        }

        if (mysqli_query($conn, $sqlUpdate)) {
            $_SESSION["HoTen"] = $hoTen;
            header("Location: index.php?page=thongtincanhan");
            exit();
        } else {
            $thongBao = "Cập nhật thất bại";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Cập nhật thông tin</title>
<style>
body{font-family:Arial;background:#f5f5f5}
.box{width:450px;margin:40px auto;background:#fff;padding:20px;border-radius:8px}
h2{text-align:center}
input{width:100%;padding:8px;margin-top:6px}
button{margin-top:15px;width:100%;padding:10px;background:#f08080;color:white;border:none;border-radius:6px}
.warning{color:red;text-align:center;margin-top:10px}
a{text-align:center;display:block;margin-top:10px}
</style>
</head>

<body>

<div class="box">
<h2>Cập nhật thông tin cá nhân</h2>

<form method="post">

    <label>Số điện thoại</label>
    <input type="text" name="sdt" value="<?= htmlspecialchars($user['SoDienThoai']) ?>">

    <label>Mật khẩu (để trống nếu không đổi)</label>
    <input type="text" name="matkhau">

    <label>Họ tên</label>
    <input type="text" name="hoten" value="<?= htmlspecialchars($user['HoTen']) ?>">

    <label>Ngày sinh</label>
    <input type="date" name="ngaysinh" value="<?= $user['NgaySinh'] ?>">

    <button type="submit">Cập nhật</button>

</form>

<?php if ($thongBao != "") { ?>
<p class="warning"><?= $thongBao ?></p>
<?php } ?>

<a href="thongtincanhan.php">⬅ Quay lại</a>

</div>

</body>
</html>
