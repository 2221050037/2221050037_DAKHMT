<?php
include("connect.php");

$error = "";


if (!isset($_GET['MaTK'])) {
    die("Thiếu mã tài khoản");
}
$maTK = (int)$_GET['MaTK'];


$sql = "SELECT * FROM tai_khoan WHERE MaTK = $maTK";
$result = mysqli_query($conn, $sql);
$taiKhoan = mysqli_fetch_assoc($result);

if (!$taiKhoan) {
    die("Tài khoản không tồn tại");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $soDienThoai = trim($_POST["so-dien-thoai"]);
    $matKhau     = trim($_POST["mat-khau"]);
    $hoTen       = trim($_POST["ho-ten"]);
    $ngaySinh    = $_POST["ngay-sinh"];
    $maQuyen     = $_POST["ma-quyen"];

    if (
        $soDienThoai == "" ||
        $matKhau == "" ||
        $hoTen == "" ||
        $ngaySinh == "" ||
        $maQuyen == ""
    ) {
        $error = "Vui lòng nhập đầy đủ thông tin";
    } else {

        
        $sqlUpdate = "
            UPDATE tai_khoan SET
                SoDienThoai = '$soDienThoai',
                MatKhau     = '$matKhau',
                HoTen       = '$hoTen',
                NgaySinh    = '$ngaySinh',
                MaQuyen     = '$maQuyen'
            WHERE MaTK = $maTK
        ";

        if (mysqli_query($conn, $sqlUpdate)) {
            header("Location: index.php?page_layout=taikhoan");
            exit();
        } else {
            $error = "Lỗi SQL: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Cập nhật tài khoản</title>

<style>
*{box-sizing:border-box;font-family:Arial}
.container{
    width:40%;
    margin:40px auto;
    border:1px solid #000;
    padding:25px;
    border-radius:15px
}
.box{margin-bottom:15px}
input, select{
    width:100%;
    padding:8px
}
input[disabled]{
    background:#eee;
    cursor:not-allowed;
}
.warning{
    color:red;
    font-weight:bold;
    text-align:center
}
</style>
</head>

<body>

<h1 style="text-align:center">CẬP NHẬT TÀI KHOẢN</h1>

<?php if ($error != "") { ?>
    <p class="warning"><?= $error ?></p>
<?php } ?>

<div class="container">
<form method="post">

    <div class="box">
        <p>Số điện thoại</p>
        <input type="text" name="so-dien-thoai"
               value="<?= htmlspecialchars($taiKhoan['SoDienThoai']) ?>">
    </div>

    <div class="box">
        <p>Mật khẩu</p>
        <input type="text" name="mat-khau"
               value="<?= htmlspecialchars($taiKhoan['MatKhau']) ?>">
    </div>

    <div class="box">
        <p>Họ tên</p>
        <input type="text" name="ho-ten"
               value="<?= htmlspecialchars($taiKhoan['HoTen']) ?>">
    </div>

    <div class="box">
        <p>Ngày sinh</p>
        <input type="date" name="ngay-sinh"
               value="<?= $taiKhoan['NgaySinh'] ?>">
    </div>


    <div class="box">
        <p>Quyền</p>
        <select name="ma-quyen">
            <option value="1" <?= $taiKhoan['MaQuyen']==1?'selected':'' ?>>Admin</option>
            <option value="2" <?= $taiKhoan['MaQuyen']==2?'selected':'' ?>>User</option>
        </select>
    </div>

    <input type="submit" value="Cập nhật">

</form>
</div>

</body>
</html>
