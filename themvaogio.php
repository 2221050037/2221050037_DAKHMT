<?php
session_start();
include("../admin/connect.php");


if (!isset($_SESSION["MaTK"])) {
    header("Location: ../dangnhap.php");
    exit();
}

if (!isset($_GET['MaSach'])) {
    header("Location: giohang.php");
    exit();
}

$maTK   = $_SESSION["MaTK"];
$maSach = (int)$_GET['MaSach'];


$sqlSach = "SELECT GiaTri FROM sach WHERE MaSach = $maSach";
$rsSach  = mysqli_query($conn, $sqlSach);
$sach    = mysqli_fetch_assoc($rsSach);

if (!$sach) {
    header("Location: giohang.php");
    exit();
}

$gia = $sach['GiaTri'];


$sqlGio = "
    SELECT * FROM don_hang
    WHERE id_nguoi_dung = $maTK
      AND id_trang_thai = 1
    LIMIT 1
";

$rsGio = mysqli_query($conn, $sqlGio);
$gio   = mysqli_fetch_assoc($rsGio);


if (!$gio) {
    $sqlCreate = "
        INSERT INTO don_hang (id_nguoi_dung, id_trang_thai, tong_tien, ngay_dat)
        VALUES ($maTK, 1, 0, NOW())
    ";
    mysqli_query($conn, $sqlCreate);
    $idDonHang = mysqli_insert_id($conn);
} else {
    $idDonHang = $gio['id'];
}


$sqlCheck = "
    SELECT * FROM chi_tiet_don_hang
    WHERE id_don_hang = $idDonHang
      AND id_sach = $maSach
";
$rsCheck = mysqli_query($conn, $sqlCheck);

if ($row = mysqli_fetch_assoc($rsCheck)) {
    
    mysqli_query($conn, "
        UPDATE chi_tiet_don_hang
        SET so_luong = so_luong + 1
        WHERE id = {$row['id']}
    ");
} else {
    
    mysqli_query($conn, "
        INSERT INTO chi_tiet_don_hang (id_don_hang, id_sach, so_luong, gia)
        VALUES ($idDonHang, $maSach, 1, $gia)
    ");
}


mysqli_query($conn, "
    UPDATE don_hang
    SET tong_tien = tong_tien + $gia
    WHERE id = $idDonHang
");


header("Location: index.php?page=giohang");
exit();
