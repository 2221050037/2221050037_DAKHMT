<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách chủ đề</title>
    <style>


*{
    box-sizing: border-box;
    font-family: Arial, Helvetica, sans-serif;
}


.control{
    width: 80%;
    margin: 30px auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.control h1{
    margin: 0;
}


.box a{
    text-decoration: none;
    background: #007bff;
    color: #fff;
    padding: 8px 14px;
    border-radius: 5px;
}

.box a:hover{
    background: #0056b3;
}


.container{
    width: 80%;
    margin: auto;
    border-collapse: collapse;
}

.container th,
.container td{
    padding: 10px;
    text-align: center;
}

.container th{
    background: #f2f2f2;
}


.chitiet{
    text-decoration: none;
    color: #007bff;
}

.chitiet:hover{
    text-decoration: underline;
}


.chucnang .btn{
    text-decoration: none;
    padding: 5px 10px;
    margin: 0 3px;
    border-radius: 4px;
    background: #28a745;
    color: white;
    font-size: 14px;
}

.chucnang .btn:last-child{
    background: #dc3545;
}

.chucnang .btn:hover{
    opacity: 0.8;
}
</style>
     
</head>
<body>
    <div class="control">
        <h1>Danh sách chủ đề</h1>
        <div class="box">
            <a href="index.php?page_layout=themchude">Thêm chủ đề</a>

        </div>

    </div>
    <table border=1 class="container">
        <tr>
        <th>Mã chủ đề</th>
        <th>Tên chủ đề</th>
        <th>Chức năng</th>
        </tr>
    <?php 
            include("connect.php");
            $sql = "SELECT `MaCD`, `TenChuDe` FROM `chu_de`";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_array($result)){
        ?> 
        <tr>
            <td><?php echo $row["MaCD"] ?></td>
            <td><a class="chitiet" href="index.php?page_layout=chitietchude&MaCD=<?php echo $row["MaCD"] ?>"><?php echo $row["TenChuDe"] ?></a></td>
            
            <td class="chucnang">
                <a class="btn" href="index.php?page_layout=capnhatchude&MaCD=<?php echo $row["MaCD"] ?>">Cập nhật</a>
                <a class="btn" href="xoachude.php?MaCD=<?php echo $row["MaCD"] ?>">Xóa</a>
            </td>
        </tr>
        <?php }?>
    </table>
    
</body>
</html>