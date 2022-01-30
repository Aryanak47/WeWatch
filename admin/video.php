
<?php 
       require_once('../includes/classes/config.php');
       $limit = 20;
       $page = isset($_GET['page']) ? $_GET['page'] :1;
       $start = ($page -1) * $limit;
       $query = $conn->prepare("SELECT * FROM users LIMIT $start, $limit");
       $query->execute();
       $users = $query->fetchAll();
       $totalFetch = count($users);
       $query = $conn->prepare("SELECT count('id') AS id FROM users ");
       $query->execute();
       $total = $query->fetchAll();
       $total = $total[0]["id"];
       $previous = $page > 1 ? $page -1:1;
       $next = $page +1;
       $totalPages = ceil($total/$limit);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet">
        <!-- <link rel="shortcut icon" type="image/png" href="img/favicon.png"> -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/style.css">
        <title>Admin Dashboard</title>
        <style>       
         .table-responsive {
            margin: 30px 0;
        }
        .table-wrapper {
            min-width: 1000px;
            background: #fff;
            padding: 20px 25px;
            border-radius: 3px;
            box-shadow: 0 1px 1px rgba(0,0,0,.05);
        }
        .table-title {
            padding-bottom: 15px;
            background: #299be4;
            color: #fff;
            padding: 16px 30px;
            margin: -20px -25px 10px;
            border-radius: 3px 3px 0 0;
        }
        .table-title h2 {
            margin: 5px 0 0;
            font-size: 24px;
        }
        .table-title .btn {
            color: #566787;
            float: right;
            font-size: 13px;
            background: #fff;
            border: none;
            min-width: 50px;
            border-radius: 2px;
            border: none;
            outline: none !important;
            margin-left: 10px;
        }
        .table-title .btn:hover, .table-title .btn:focus {
            color: #566787;
            background: #f2f2f2;
        }
        .table-title .btn i {
            float: left;
            font-size: 21px;
            margin-right: 5px;
        }
        .table-title .btn span {
            float: left;
            margin-top: 2px;
        }
        table.table tr th, table.table tr td {
            border-color: #e9e9e9;
            padding: 12px 15px;
            vertical-align: middle;
        }
        table.table tr th:first-child {
            width: 60px;
        }
        table.table tr th:last-child {
            width: 100px;
        }
        table.table-striped tbody tr:nth-of-type(odd) {
            background-color: #fcfcfc;
        }
        table.table-striped.table-hover tbody tr:hover {
            background: #f5f5f5;
        }
        table.table th i {
            font-size: 13px;
            margin: 0 5px;
            cursor: pointer;
        }	
        table.table td:last-child i {
            opacity: 0.9;
            font-size: 22px;
            margin: 0 5px;
        }
        table.table td a {
            font-weight: bold;
            color: #566787;
            display: inline-block;
            text-decoration: none;
        }
        table.table td a:hover {
            color: #2196F3;
        }
        table.table td a.settings {
            color: #2196F3;
        }
        table.table td a.delete {
            color: #F44336;
        }
        table.table td i {
            font-size: 19px;
        }
        table.table .avatar {
            border-radius: 50%;
            vertical-align: middle;
            margin-right: 10px;
        }
        .status {
            font-size: 30px;
            margin: 2px 2px 0 0;
            display: inline-block;
            vertical-align: middle;
            line-height: 10px;
        }
        .status-content {
            display: flex;
            align-items: center;
        }
        .text-success {
            color: #10c469;
        }
        .text-info {
            color: #62c9e8;
        }
        .text-warning {
            color: #FFC107;
        }
        .text-danger {
            color: #ff5b5b;
        }
        .pagination {
            float: right;
            margin: 0 0 5px;
        }
        .pagination li a {
            border: none;
            font-size: 13px;
            min-width: 30px;
            min-height: 30px;
            color: #999;
            margin: 0 2px;
            line-height: 30px;
            border-radius: 2px !important;
            text-align: center;
            padding: 0 6px;
        }
        .pagination li a:hover {
            color: #666;
        }	
        .pagination li.active a, .pagination li.active a.page-link {
            background: #03A9F4;
        }
        .pagination li.active a:hover {        
            background: #0397d6;
        }
        .pagination li.disabled i {
            color: #ccc;
        }
        .pagination li i {
            font-size: 16px;
            padding-top: 6px
        }
        .hint-text {
            float: left;
            margin-top: 10px;
            font-size: 13px;
        }
        </style>
    </head>
    <body>
        <div class="layout-container">
            <div class="sidebar">
                <h2 class="title">Dashboard</h2>
                <nav>
                    <ul class="side-nav">
                        <li class="side-nav__item">
                            <a href="index.php" class="side-nav__link">
                                <svg class="side-nav__icon">
                                    <use xlink:href="img/sprite2.svg#icon-user-tie"></use>
                                </svg>
                                <span>User</span>
                            </a>
                        </li>
                        <li class="side-nav__item side-nav__item--active">
                            <a href="video.php" class="side-nav__link">
                                <svg class="side-nav__icon">
                                    <use xlink:href="img/sprite2.svg#icon-film"></use>
                                </svg>
                                <span>Videos</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="main">
                <header class="header">

                    <form action="#" class="search">
                        <input type="text" class="search__input" placeholder="Search Videos">
                        <button class="search__button">
                            <svg class="search__icon">
                                <use xlink:href="img/sprite.svg#icon-magnifying-glass"></use>
                            </svg>
                        </button>
                    </form>

                    <nav class="user-nav">
                        <div class="user-nav__icon-box">
                            <svg class="user-nav__icon">
                                <use xlink:href="img/sprite.svg#icon-bookmark"></use>
                            </svg>
                            <span class="user-nav__notification">7</span>
                        </div>
                        <div class="user-nav__icon-box">
                            <svg class="user-nav__icon">
                                <use xlink:href="img/sprite.svg#icon-chat"></use>
                            </svg>
                            <span class="user-nav__notification">13</span>
                        </div>
                        <div class="user-nav__user">
                            <img src="img/user-1.jpg" alt="User photo" class="user-nav__user-photo">
                            <span class="user-nav__user-name">Admin</span>
                        </div>
                    </nav>
                </header>
                    


                    <main class="video-info">
                 

                    </main>
            </div>
        </div>
    </body>
    <script src="js/script.js"></script>
</html>
