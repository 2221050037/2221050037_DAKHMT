<?php 
    include('connect.php');
    $maTK = $_GET['MaTK'];
    $sql = "DELETE FROM `tai_khoan` WHERE  MaTK = '$maTK'";
    mysqli_query($conn, $sql);
    header('location: index.php?page_layout=taikhoan');
?>