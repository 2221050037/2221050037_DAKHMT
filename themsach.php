<?php
include("connect.php");


$sqlCD = "SELECT MaCD, TenChuDe FROM chu_de";
$dsChuDe = mysqli_query($conn, $sqlCD);

$sqlTG = "SELECT MaTacGia, TenTacGia FROM tacgia";
$dsTacGia = mysqli_query($conn, $sqlTG);


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (
        !empty($_POST["tua-sach"]) &&
        !empty($_POST["ma-cd"]) &&
        !empty($_POST["ma-tac-gia"]) &&
        !empty($_POST["gia-tri"]) &&
        isset($_POST["so-luong"]) &&
        !empty($_POST["mo-ta"]) &&
        !empty($_FILES["hinh-anh"]["name"])
    ) {
        $tuaSach  = $_POST["tua-sach"];
        $maCD     = $_POST["ma-cd"];
        $maTacGia = $_POST["ma-tac-gia"];
        $giaTri   = $_POST["gia-tri"];
        $soLuong  = $_POST["so-luong"];
        $moTa     = $_POST["mo-ta"];

    
        $sqlTenTG = "SELECT TenTacGia FROM tacgia WHERE MaTacGia = '$maTacGia'";
        $kqTG = mysqli_query($conn, $sqlTenTG);
        $rowTG = mysqli_fetch_assoc($kqTG);
        $tenTacGia = $rowTG['TenTacGia'];

      
        $tenAnh = $_FILES["hinh-anh"]["name"];
        $tmp    = $_FILES["hinh-anh"]["tmp_name"];
        move_uploaded_file($tmp, "uploads/" . $tenAnh);

       
        $sql = "INSERT INTO sach 
                (TuaSach, HinhAnh, TacGia, GiaTri, SoLuong, MoTa, MaCD)
                VALUES 
                ('$tuaSach', '$tenAnh', '$tenTacGia', '$giaTri', '$soLuong', '$moTa', '$maCD')";

        mysqli_query($conn, $sql);
        mysqli_close($conn);

        header("Location: index.php?page_layout=sach");
        exit();
    } else {
        $loi = "Vui lòng nhập đầy đủ thông tin";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm sách</title>
    <style>
        *{
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }
        body{
            background: #fff;
        }
        .container{
            width: 40%;
            margin: 40px auto;
            border: 1px solid #000;
            border-radius: 15px;
            padding: 30px;
        }
        h1{
            text-align: center;
            margin-bottom: 20px;
        }
        p{
            font-weight: bold;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="number"],
        select{
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
        }
        input[type="file"]{
            margin-bottom: 15px;
        }
        input[type="submit"]{
            width: 100%;
            padding: 10px;
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
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="container">
<form action="index.php?page_layout=themsach" method="post" enctype="multipart/form-data">

    <h1>Thêm tác phẩm</h1>

    <?php if (!empty($loi)) echo "<p class='warning'>$loi</p>"; ?>

    <div>
        <p>Tên sách</p>
        <input type="text" name="tua-sach" placeholder="Tên sách">
    </div>

    <div>
        <p>Chủ đề</p>
        <select name="ma-cd">
            <option value="">-- Chọn chủ đề --</option>
            <?php while ($row = mysqli_fetch_assoc($dsChuDe)) { ?>
                <option value="<?= $row['MaCD'] ?>">
                    <?= $row['TenChuDe'] ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div>
        <p>Hình ảnh</p>
        <input type="file" name="hinh-anh">
    </div>

    <div>
        <p>Tác giả</p>
        <select name="ma-tac-gia">
            <option value="">-- Chọn tác giả --</option>
            <?php while ($row = mysqli_fetch_assoc($dsTacGia)) { ?>
                <option value="<?= $row['MaTacGia'] ?>">
                    <?= $row['TenTacGia'] ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div>
        <p>Giá trị</p>
        <input type="number" name="gia-tri" placeholder="Giá trị">
    </div>

   
    <div>
        <p>Số lượng</p>
        <input type="number" name="so-luong" min="0" placeholder="Số lượng">
    </div>

    <div>
        <p>Mô tả</p>
        <input type="text" name="mo-ta" placeholder="Mô tả">
    </div>

    <div>
        <input type="submit" value="Thêm sách">
    </div>

</form>
</div>

</body>
</html>
