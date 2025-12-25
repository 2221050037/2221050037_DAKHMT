<?php
            include("connect.php");
            if(!empty($_POST["ten-chu-de"])){

                    $tenChuDe = $_POST["ten-chu-de"];
                    
                    
                    $sql = "INSERT INTO chu_de (`TenChuDe`) VALUES ('$tenChuDe')";
                    mysqli_query($conn,$sql);
                    mysqli_close($conn);
                    header('location: index.php?page_layout=chude');
                }else{
                    echo '<p class="warning">Vui lòng nhập đầy đủ thông tin</p>';
                }
        ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>themdongvat</title>
    <style>
        *{
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body{
            background: #fff;
        }

        /* Thông báo lỗi */
        .warning{
            text-align: center;
            color: red;
            font-weight: bold;
            margin-top: 20px;
        }

        /* Khung form */
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
    <form action="index.php?page_layout=themchude" method="post" enctype="multipart/form-data">   
        <h1>Thêm chủ đề</h1>
        <div>
            <p>Tên chủ đề</p>
            <input type="text" name="ten-chu-de" placeholder="Tên chủ đề">
        </div>
        
        <div><input type="submit" value="Thêm"></div>

    </form>
    </div>
</body>
</html>