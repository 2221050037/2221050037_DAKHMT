<?php
include("connect.php");

/* KIỂM TRA ID */
if (!isset($_GET['MaTacGia'])) {
    header("location: index.php?page_layout=tacgia");
    exit();
}
$maTacGia = $_GET['MaTacGia'];

/* XỬ LÝ CẬP NHẬT */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tenTacGia = $_POST['ten-tac-gia'];
    $ngaySinh  = $_POST['ngay-sinh'];
    $quocTich  = $_POST['quoc-tich'];
    $moTa      = $_POST['mo-ta'];

    if ($tenTacGia != '' && $ngaySinh != '' && $quocTich != '') {
        $sql = "UPDATE tacgia SET
                    TenTacGia = '$tenTacGia',
                    NgaySinh  = '$ngaySinh',
                    QuocTich  = '$quocTich',
                    MoTa      = '$moTa'
                WHERE MaTacGia = '$maTacGia'";
        mysqli_query($conn, $sql);

        header("location: index.php?page_layout=tacgia");
        exit();
    } else {
        echo '<p class="warning">Vui lòng nhập đầy đủ thông tin</p>';
    }
}

/* LẤY DỮ LIỆU CŨ */
$sql = "SELECT * FROM tacgia WHERE MaTacGia = '$maTacGia'";
$result = mysqli_query($conn, $sql);
$tacgia = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cập nhật</title>
     <style>
    *{
        box-sizing: border-box;
        font-family: Arial, Helvetica, sans-serif;
    }

    body{
        background: #fff;
    }

    p{
        font-weight: bold;
        margin: 5px 0;
    }

    h1{
        margin-bottom: 15px;
    }

    /* Khung form */
    .container{
        width: 40%;
        margin: 40px auto;
        border: 1px solid #000;
        border-radius: 15px;
        padding: 25px;
        display: flex;
        justify-content: center;
    }

    form{
        width: 100%;
    }

    .box{
        margin-bottom: 15px;
    }

    /* Input */
    input[type="text"]{
        width: 100%;
        padding: 8px;
    }

    /* Nút cập nhật */
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

    /* Thông báo lỗi */
    .warning{
        text-align: center;
        color: red;
        font-weight: bold;
        margin-top: 20px;
    }
</style>
</head>
<body>
    <div class="container">
        <form action="index.php?page_layout=capnhattacgia&MaTacGia=<?php echo $maTacGia ?>" method="post">
            <div class="box">
                <p>Tên tác giả</p>
                <input type="text" name="ten-tac-gia" 
                    value="<?php echo $tacgia['TenTacGia']; ?>">
            </div>
            <div class="box">
                <p>Ngày sinh</p>
                <input type="date" name="ngay-sinh" 
                    value="<?php echo $tacgia['NgaySinh']; ?>">
            </div>
            <div class="box">
                <p>Quốc tịch</p>
                <input type="text" name="quoc-tich" 
                    value="<?php echo $tacgia['QuocTich']; ?>">
            </div>
            <div class="box">
                <p>Mô tả</p>
                <input type="text" name="mo-ta" 
                    value="<?php echo $tacgia['MoTa']; ?>">
            </div>
            
            <div class="box">
                <input type="submit" value="Cập nhật">
            </div>
        </form>
    </div>
</body>
</html>