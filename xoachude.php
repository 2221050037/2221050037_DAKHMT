<?php 
    include('connect.php');
    $maCD = $_GET['MaCD'];
    $sql = "DELETE FROM `chu_de` WHERE  MaCD = '$maCD'";
    mysqli_query($conn, $sql);
    header('location: index.php?page_layout=chude');
?>