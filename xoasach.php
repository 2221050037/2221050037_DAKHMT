<?php 
    include('connect.php');
    $maSach = $_GET['MaSach'];
    $sql = "DELETE FROM `sach` WHERE  MaSach = '$maSach'";
    mysqli_query($conn, $sql);
    header('location: index.php?page_layout=sach');
?>