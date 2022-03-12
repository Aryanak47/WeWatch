<?php
require_once("includes/config.php");
require_once('includes/classes/FormSanitizer.php');
require_once('includes/classes/Constant.php');
require_once('includes/classes/Account.php');
require_once("includes/classes/EntityProvider.php");
require_once("includes/classes/Entity.php");
require_once("includes/classes/Category.php");
require_once("includes/classes/SeasonProvider.php");
require_once("includes/classes/Video.php");
require_once("includes/classes/Season.php");
require_once("includes/classes/ErrorMessage.php");
require_once("includes/classes/VideoProvider.php");
require_once("includes/classes/User.php");

 $script_name = $_SERVER['SCRIPT_NAME'];
 $script_name = explode('/', $script_name);
 $mypage = $script_name[count($script_name)-1];
 if($mypage == "login.php" || $mypage == "register.php"){

}else{
    if(!isset($_SESSION["userLoggedIn"])) {
        header("location:login.php");
    }else{
        $userLoggedIn = $_SESSION["userLoggedIn"];
    }
}
 $og_name = "We Watch";
 $og_image = "";
 $og_url = $SITE_URL;
 if($mypage =="entity.php"){
     $myPageId = FormSanitizer::getSafeValue($_GET['id']);
     $query = $conn->prepare("SELECT * FROM entities where id =:id ");
     $query->bindValue(':id',$myPageId);
     $query->execute();
     $videoInfo = $query->fetch(PDO::FETCH_ASSOC);
     $og_name = $videoInfo['name'];
     $og_image = $videoInfo['thumbnail'];
     $og_url = $SITE_URL."/entity.php?id=$myPageId";
 }
 

?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width">
        <meta property="og:title" content="<?php echo $og_name ?>" />
        <meta property="og:image" content="<?php echo $og_image ?>" />
        <meta property="og:url" content="<?php echo $og_url ?>" />
        <meta property="og:site_name" content="<?php echo $SITE_URL."/"; ?>" />
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
