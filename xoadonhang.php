<?php
session_start();
include("../admin/connect.php");

if (!isset($_SESSION['MaTK'])) {
    header("Location: dangnhap.php");
    exit();
}

$maTK = (int)$_SESSION['MaTK'];

if (!isset($_GET['id_don'])) {
    header("Location: giohang.php");
    exit();
}

$idDon = (int)$_GET['id_don'];

$rs = mysqli_query($conn, "
    SELECT id
    FROM don_hang
    WHERE id = $idDon
      AND id_nguoi_dung = $maTK
      AND id_trang_thai = 1
");

if (mysqli_num_rows($rs) == 0) {
    
    header("Location: giohang.php");
    exit();
}


mysqli_query($conn, "
    DELETE FROM chi_tiet_don_hang
    WHERE id_don_hang = $idDon
");


mysqli_query($conn, "
    DELETE FROM don_hang
    WHERE id = $idDon
");

header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'giohang.php'));
exit();
