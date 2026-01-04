<?php
include_once "connect.php";

if (!isset($_GET['MaCD'])) {
    die("Thiếu mã chủ đề");
}

$maCD = $_GET['MaCD'];
$error = "";

if (isset($_POST['ten-chu-de'])) {
    if ($_POST['ten-chu-de'] !== '') {
        $tenChuDe = $_POST['ten-chu-de'];

        $sql = "UPDATE chu_de 
                SET TenChuDe = '$tenChuDe' 
                WHERE MaCD = '$maCD'";
        mysqli_query($conn, $sql);

        header("location: index.php?page_layout=chude");
        exit();
    } else {
        $error = "Vui lòng nhập đầy đủ thông tin";
    }
}

$sql = "SELECT * FROM chu_de WHERE MaCD = '$maCD'";
$result = mysqli_query($conn, $sql);
$chude = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cập nhật chủ đề</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

        input[type="text"]{
            width: 100%;
            padding: 8px;
        }

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
        <form action="index.php?page_layout=capnhatchude&MaCD=<?php echo $maCD; ?>" method="post">
            <h1>Cập nhật chủ đề</h1>

            <div class="box">
                <p>Tên chủ đề</p>
                <input type="text" name="ten-chu-de"
                       value="<?php echo $chude['TenChuDe']; ?>">
            </div>

            <div class="box">
                <input type="submit" value="Cập nhật">
            </div>

            <?php if ($error != ""): ?>
                <p class="warning"><?php echo $error; ?></p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
