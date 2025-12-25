<?php
session_start();

if (!isset($_SESSION['maquyen']) || $_SESSION['maquyen'] != 2) {
    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Trang admin</title>
   <style>
      body { margin: 0; }
      nav {
         background-color: cornflowerblue;
         display: flex;
         justify-content: space-between;
      }
      ul {
         display: flex;
         list-style: none;
         margin: 0;
      }
      li { padding: 10px; }
      a { text-decoration: none; }
   </style>
</head>

<body>
   <header>
      <nav>
         <ul>
            <li><a href="index.php?page_layout=trangchu">Trang chủ</a></li>
            <li><a href="index.php?page_layout=sach">Sách</a></li>
            <li><a href="index.php?page_layout=chude">Chủ đề</a></li>
            <li><a href="index.php?page_layout=tacgia">Tác giả</a></li>
            <li><a href="index.php?page_layout=taikhoan">Tài khoản</a></li>
         </ul>
         <ul>
            <li><?php echo "Xin chào " . $_SESSION["username"]; ?></li>
            <li><a href="index.php?page_layout=dangxuat">Đăng xuất</a></li>
         </ul>
      </nav>

<?php
if (isset($_GET['page_layout'])) {
    switch ($_GET['page_layout']) {
        case 'trangchu': include "trangchu.php"; break;
        case 'sach': include "sach.php"; break;
        case 'chude': include "chude.php"; break;
        case 'tacgia': include "tacgia.php"; break;
        case 'taikhoan': include "taikhoan.php"; break;
        case 'themtaikhoan': include "themtaikhoan.php"; break;
        case 'capnhattaikhoan': include "capnhattaikhoan.php"; break;
        case 'themtacgia': include "themtacgia.php"; break;
        case 'capnhattacgia': include "capnhattacgia.php"; break;
        case 'themchude': include "themchude.php"; break;
        case 'xoachude': include "xoachude.php"; break;
        case 'capnhatchude': include "capnhatchude.php"; break;
        case 'themsach': include "themsach.php"; break;
        case 'capnhatsach': include "capnhatsach.php"; break;
        case 'xoasach': include "xoasach.php"; break;
        case 'xoatacgia': include "xoatacgia.php"; break;

        case 'dangxuat':
            session_destroy();
            header("Location: login.php");
            exit();

        default:
            include "trangchu.php";
    }
}
?>
   </header>
</body>
</html>
