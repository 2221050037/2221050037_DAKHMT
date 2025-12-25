<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Book Store</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body{
            min-height:2000px;
            background:#f5f5f5;
        }

        /* ===== HEADER ===== */
        .header{
            position: sticky;
            top:0;
            z-index:1000;
            background:#f2c1b6;
            padding:12px 40px;
            display:flex;
            align-items:center;
            justify-content:space-between;
        }

        .logo{
            font-size:26px;
            font-weight:bold;
            color:white;
        }

        .nav{
            display:flex;
            align-items:center;
            gap:25px;
        }

        /* ===== LINK FIX ===== */
        .nav a{
            color:white;
            text-decoration:none;
            font-size:16px;
            cursor:pointer;
        }

        .nav a:hover,
        .nav a:focus,
        .nav a:active,
        .nav a:visited{
            text-decoration:none;
        }

        /* ===== DROPDOWN ===== */
        .dropdown{
            position:relative;
            cursor:pointer;
        }

        .dropdown-title{
            color:white;
            user-select:none;
        }

        .dropdown-menu{
            display:none;
            position:absolute;
            top:40px;
            left:0;
            background:white;
            min-width:180px;
            border-radius:6px;
            box-shadow:0 4px 10px rgba(0,0,0,0.2);
            overflow:hidden;
        }

        .dropdown-menu a{
            display:block;
            padding:12px 16px;
            color:#333;
            text-decoration:none;
        }

        .dropdown-menu a:hover{
            background:#eee;
        }

        .dropdown.active .dropdown-menu{
            display:block;
        }

        /* ===== SEARCH ===== */
        .search{
            display:flex;
            align-items:center;
        }

        .search input{
            padding:6px 10px;
            border:none;
            border-radius:4px 0 0 4px;
            outline:none;
        }

        .search button{
            padding:6px 12px;
            border:none;
            background:#ff8c7a;
            color:white;
            border-radius:0 4px 4px 0;
            cursor:pointer;
        }

        /* ===== ICONS ===== */
        .icons{
            display:flex;
            align-items:center;
            gap:20px;
            color:white;
            cursor:pointer;
        }

        .account{
            position:relative;
        }

        .account-menu{
            display:none;
            position:absolute;
            top:40px;
            right:0;
            background:white;
            min-width:200px;
            border-radius:6px;
            box-shadow:0 4px 10px rgba(0,0,0,0.2);
            overflow:hidden;
        }

        .account-menu a{
            display:block;
            padding:12px 16px;
            color:#333;
            text-decoration:none;
        }

        .account-menu a:hover{
            background:#eee;
        }

        .account.active .account-menu{
            display:block;
        }

        /* ===== CONTENT ===== */
        .content{
            margin:60px auto;
            width:80%;
            background:white;
            padding:50px;
            border-radius:10px;
            text-align:center;
            box-shadow:0 4px 10px rgba(0,0,0,0.1);
        }

        .content h1{
            font-size:36px;
            margin-bottom:15px;
        }

        .content p{
            font-size:18px;
            color:#555;
        }
    </style>
</head>

<body>

<div class="header">

    <div class="logo">Book Store</div>

    <div class="nav">
        <a href="#">Trang chủ</a>

        <div class="dropdown" onclick="toggleCategory(event)">
            <span class="dropdown-title">Thể loại ▾</span>
            <div class="dropdown-menu">
                <a href="#">Tiểu thuyết</a>
                <a href="#">Trinh thám</a>
                <a href="#">Truyện tranh</a>
                <a href="#">SGK</a>
            </div>
        </div>
    </div>

    <div class="search">
        <input type="text" placeholder="Nhập tên sách...">
        <button>Tìm</button>
    </div>

    <div class="icons">
        <div>Giỏ hàng</div>

        <div class="account" onclick="toggleAccount(event)">
            Tài khoản
            <div class="account-menu">
                <a href="#">Đăng nhập</a>
                <a href="#">Đăng ký</a>
                <a href="#">Thông tin cá nhân</a>
                <a href="#">Đăng xuất</a>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <h1>Chào mừng đến với Book Store</h1>
    <p>Khám phá kho sách phong phú – nhanh chóng – trải nghiệm tiện lợi.</p>
</div>

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

    document.addEventListener('click', function(){
        document.querySelector('.dropdown').classList.remove('active');
        document.querySelector('.account').classList.remove('active');
    });
</script>

</body>
</html>
