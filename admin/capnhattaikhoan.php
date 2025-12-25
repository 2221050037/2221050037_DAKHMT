<?php
include("connect.php");

$error = "";

/* ===== KIỂM TRA MaTK ===== */
if (!isset($_GET['MaTK'])) {
    die("Thiếu mã tài khoản");
}
$maTK = $_GET['MaTK'];

/* ===== LẤY DỮ LIỆU CŨ ===== */
$sql = "SELECT * FROM tai_khoan WHERE MaTK='$maTK'";
$result = mysqli_query($conn, $sql);
$taiKhoan = mysqli_fetch_assoc($result);

if (!$taiKhoan) {
    die("Tài khoản không tồn tại");
}

/* ===== XỬ LÝ CẬP NHẬT ===== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $soDienThoai = trim($_POST["so-dien-thoai"]);
    $matKhau     = trim($_POST["mat-khau"]);
    $hoTen       = trim($_POST["ho-ten"]);
    $ngaySinh    = $_POST["ngay-sinh"];
    $viTien      = $_POST["vi-tien"];
    $maQuyen     = $_POST["ma-quyen"];

    if (
        $soDienThoai == "" ||
        $matKhau == "" ||
        $hoTen == "" ||
        $ngaySinh == "" ||
        $viTien === "" ||
        $maQuyen == ""
    ) {
        $error = "Vui lòng nhập đầy đủ thông tin";
    } else {

        /* ===== XỬ LÝ ẢNH ===== */
        if (!empty($_FILES["hinh-anh"]["name"])) {
            $ext = pathinfo($_FILES["hinh-anh"]["name"], PATHINFO_EXTENSION);
            $tenAnh = time() . "_avatar." . $ext;

            if (!is_dir("uploads")) {
                mkdir("uploads");
            }

            move_uploaded_file($_FILES["hinh-anh"]["tmp_name"], "uploads/$tenAnh");
        } else {
            $tenAnh = $taiKhoan['HinhAnh']; // giữ ảnh cũ
        }

        /* ===== UPDATE ===== */
        $sql = "
            UPDATE tai_khoan SET
                SoDienThoai = '$soDienThoai',
                MatKhau     = '$matKhau',
                HoTen       = '$hoTen',
                HinhAnh     = '$tenAnh',
                NgaySinh    = '$ngaySinh',
                ViTien      = '$viTien',
                MaQuyen     = '$maQuyen'
            WHERE MaTK = '$maTK'
        ";

        if (mysqli_query($conn, $sql)) {
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
.container{width:40%;margin:40px auto;border:1px solid #000;padding:25px;border-radius:15px}
.box{margin-bottom:15px}
input{width:100%;padding:8px}
.warning{color:red;font-weight:bold;text-align:center}
</style>
</head>

<body>

<h1 style="text-align:center">CẬP NHẬT TÀI KHOẢN</h1>

<?php if ($error != "") { ?>
    <p class="warning"><?= $error ?></p>
<?php } ?>

<div class="container">
<form method="post" enctype="multipart/form-data">

    <div class="box">
        <p>Số điện thoại</p>
        <input type="text" name="so-dien-thoai"
               value="<?= $taiKhoan['SoDienThoai'] ?>">
    </div>

    <div class="box">
        <p>Mật khẩu</p>
        <input type="text" name="mat-khau"
               value="<?= $taiKhoan['MatKhau'] ?>">
    </div>

    <div class="box">
        <p>Họ tên</p>
        <input type="text" name="ho-ten"
               value="<?= $taiKhoan['HoTen'] ?>">
    </div>

    <div class="box">
        <p>Hình ảnh (bỏ trống nếu không đổi)</p>
        <input type="file" name="hinh-anh">
        <br><br>
        <img src="uploads/<?= $taiKhoan['HinhAnh'] ?>" width="100">
    </div>

    <div class="box">
        <p>Ngày sinh</p>
        <input type="date" name="ngay-sinh"
               value="<?= $taiKhoan['NgaySinh'] ?>">
    </div>

    <div class="box">
        <p>Ví tiền</p>
        <input type="number" name="vi-tien"
               value="<?= $taiKhoan['ViTien'] ?>">
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
