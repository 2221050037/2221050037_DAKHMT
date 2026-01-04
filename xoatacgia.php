<?php 
    include('connect.php');
    $maTacGia = $_GET['MaTacGia'];
    $sql = "DELETE FROM `tacgia` WHERE  MaTacGia = '$maTacGia'";
    mysqli_query($conn, $sql);
    header('location: index.php?page_layout=tacgia');
?>