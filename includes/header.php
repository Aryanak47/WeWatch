<?php
require_once("includes/config.php");
require_once("includes/classes/EntityProvider.php");
require_once("includes/classes/Entity.php");
require_once("includes/classes/Category.php");
require_once("includes/classes/SeasonProvider.php");
require_once("includes/classes/Video.php");
require_once("includes/classes/Season.php");
require_once("includes/classes/ErrorMessage.php");
require_once("includes/classes/VideoProvider.php");

if(!isset($_SESSION["userLoggedIn"])) {
    header("Location: register.php");
}

$userLoggedIn = $_SESSION["userLoggedIn"];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Welcome to WeWatch</title>
        <!-- custom csss -->
        <link rel="stylesheet" type="text/css" href="assets/style/style.css" />
        <!-- font -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
       
        <link rel="stylesheet" href="assets/style/vendors/bootstrap.min.css" />       
        <link rel="stylesheet" href="assets/style/vendors/slick.css" />
        <link rel="stylesheet" href="assets/style/vendors/slick-theme.css" />
        <link rel="stylesheet" href="assets/style/vendors/owl.carousel.min.css" />
        <link rel="stylesheet" href="assets/style/vendors/animate.min.css" />
        <link rel="stylesheet" href="assets/style/vendors/magnific-popup.css" />
        <!-- <link rel="stylesheet" href="assets/style/vendors/select2.min.css" /> -->
        <!-- <link rel="stylesheet" href="assets/style/vendors/select2-bootstrap4.min.css" /> -->
        <link rel="stylesheet" href="assets/style/vendors/slick-animation.css" />
        <link rel="stylesheet" href="assets/style/style.css" />


        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/06a651c8da.js" crossorigin="anonymous"></script>
        <script src="assets/js/vendors/popper.min.js"></script>
        <script src="assets/js/vendors/bootstrap.min.js"></script>
        <script src="assets/js/vendors/slick.min.js"></script>
        <script src="assets/js/vendors/owl.carousel.min.js"></script>
        <script src="assets/js/vendors/select2.min.js"></script>
        <script src="assets/js/vendors/jquery.magnific-popup.min.js"></script>
        <script src="assets/js/vendors/slick-animation.min.js"></script>
        <script src="assets/js/script.js"></script>


    </head>
    <?php
     include_once("includes/navbar.php")
    ?>
   
    <body>
