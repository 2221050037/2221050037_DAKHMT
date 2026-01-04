<?php
            include("connect.php");
            if(!empty($_POST["ten-tac-gia"])&&
                !empty($_POST["ngay-sinh"]) &&
                !empty($_POST["quoc-tich"]) &&
                !empty($_POST["mo-ta"])){

                    $tenTacGia = $_POST["ten-tac-gia"];
                    $ngaySinh = $_POST["ngay-sinh"];
                    $quocTich = $_POST["quoc-tich"];
                    $moTa = $_POST["mo-ta"];
                    
                    
                    $sql = "INSERT INTO tacgia (`TenTacGia`, `NgaySinh`,`QuocTich`,`MoTa`) VALUES ('$tenTacGia','$ngaySinh','$quocTich','$moTa')";
                    mysqli_query($conn,$sql);
                    mysqli_close($conn);
                    header('location: index.php?page_layout=tacgia');
                }else{
                    echo '<p class="warning">Vui lòng nhập đầy đủ thông tin</p>';
                }
        ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm tác giả</title>
    <style>
        *{
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body{
            background: #fff;
        }

        
        .warning{
            text-align: center;
            color: red;
            font-weight: bold;
            margin-top: 20px;
        }

       
        .container{
            width: 40%;
            margin: 40px auto;
            border: 1px solid #000;
            border-radius: 15px;
            padding: 30px;
        }

        h1{
            margin-bottom: 20px;
        }

        p{
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"]{
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
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
    </style>
     
</head>
<body>
    <div class="container">
    <form action="index.php?page_layout=themtacgia" method="post" enctype="multipart/form-data">   
        <h1>Thêm tác giả</h1>
        <div>
            <p>Tên tác giả</p>
            <input type="text" name="ten-tac-gia" placeholder="Tên tác giả">
        </div>
        <div>
            <p>Ngày sinh</p>
            <input type="date" name="ngay-sinh" placeholder="Ngày sinh">
        </div>
        <div>
            <p>Quốc tịch</p>
            <input type="text" name="quoc-tich" placeholder="Quốc tịch">
        </div>
        <div>
            <p>Mô tả</p>
            <input type="text" name="mo-ta" placeholder="Mô tả">
        </div>
        
        <div><input type="submit" value="Thêm"></div>

    </form>
    </div>
</body>
</html>