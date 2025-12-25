<?php
session_start();
include("../admin/connect.php");

if (!isset($_SESSION["MaTK"])) {
    header("Location: ../dangnhap.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Book Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:Arial,Helvetica,sans-serif}
        body{background:#f5f5f5}

        .header{
            position:sticky;top:0;z-index:1000;
            background:#f2c1b6;padding:12px 40px;
            display:flex;align-items:center;justify-content:space-between;
        }

        .logo{font-size:26px;font-weight:bold;color:white}
        .nav{display:flex;align-items:center;gap:25px}
        .nav a{color:white;text-decoration:none}

        .dropdown{position:relative;cursor:pointer;color:white}
        .dropdown-menu{
            display:none;position:absolute;top:40px;left:0;
            background:white;min-width:180px;border-radius:6px;
            box-shadow:0 4px 10px rgba(0,0,0,0.2)
        }
        .dropdown-menu a{display:block;padding:12px;color:#333;text-decoration:none}
        .dropdown-menu a:hover{background:#eee}
        .dropdown.active .dropdown-menu{display:block}

        .icons{display:flex;align-items:center;gap:20px;color:white}

        .account{position:relative;cursor:pointer}
        .account-menu{
            display:none;position:absolute;top:40px;right:0;
            background:white;min-width:200px;border-radius:6px;
            box-shadow:0 4px 10px rgba(0,0,0,0.2)
        }
        .account-menu a{display:block;padding:12px;color:#333;text-decoration:none}
        .account-menu a:hover{background:#eee}
        .account.active .account-menu{display:block}

        main{width:85%;margin:auto;margin-top:20px}
        .GH{text-decoration:none;color:white;font-weight:bold}

        .search input{padding:6px 8px;border-radius:4px;border:none}
        .search button{padding:6px 12px;border:none;border-radius:4px;cursor:pointer}
    </style>
</head>

<body>


<div class="header">
    <div class="logo">Book Store</div>

    <div class="nav">
        <a href="index.php">Trang chủ</a>

        <div class="dropdown" onclick="toggleCategory(event)">
            <span>Thể loại ▾</span>
            <div class="dropdown-menu">
                <a href="index.php?page=tieuthuyet">Tiểu thuyết</a>
                <a href="index.php?page=trinhtham">Trinh thám</a>
                <a href="index.php?page=truyentranh">Truyện tranh</a>
                <a href="index.php?page=SGK">SGK</a>
            </div>
        </div>
    </div>

    <div class="icons">
       
        <form class="search" method="GET" action="index.php">
            <input type="hidden" name="page" value="timkiem">
            <input type="text" name="keyword" placeholder="Tìm sách..."
                   value="<?php echo $_GET['keyword'] ?? ''; ?>">
            <button type="submit">Tìm</button>
        </form>

        <a href="index.php?page=giohang" class="GH">Giỏ hàng</a>

        <div class="account" onclick="toggleAccount(event)">
            <?php echo $_SESSION["HoTen"]; ?>
            <div class="account-menu">
                <a href="index.php?page=thongtincanhan">Thông tin cá nhân</a>
                <a href="index.php?page=dangxuat">Đăng xuất</a>
            </div>
        </div>
    </div>
</div>


<main>
<?php
$page = $_GET['page'] ?? 'trangchu';

switch ($page) {
    case 'trangchu': include "trangchu.php"; break;
    case 'tieuthuyet': include "tieuthuyet.php"; break;
    case 'trinhtham': include "trinhtham.php"; break;
    case 'truyentranh': include "truyentranh.php"; break;
    case 'SGK': include "SGK.php"; break;
    case 'giohang': include "giohang.php"; break;
    case 'thongtincanhan': include "thongtincanhan.php"; break;
    case 'capnhatthongtincanhan': include "capnhatthongtincanhan.php"; break;
    case 'timkiem': include "timkiem.php"; break;

    case 'dangxuat':
        session_destroy();
        header("Location: ../dangnhap.php");
        exit();

    default: include "trangchu.php";
}
?>
</main>

<script>
function toggleCategory(e){
    e.stopPropagation();
    document.querySelector('.dropdown').classList.toggle('active');
    document.querySelector('.account').classList.remove('active');
}
function toggleAccount(e){
    e.stopPropagation();
    document.querySelector('.account').classList.toggle('active');
    document.querySelector('.dropdown').classList.remove('active');
}
document.addEventListener('click', ()=>{
    document.querySelector('.dropdown').classList.remove('active');
    document.querySelector('.account').classList.remove('active');
});
</script>

</body>
</html>
