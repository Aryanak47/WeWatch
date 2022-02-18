<?php
require_once("config.php");
if(isset($_SESSION["role"]) && $_SESSION['role'] === "admin") {
    
    
}else{
    header("Location:$SITE_URL/register.php");
    die();
}

$userLoggedIn = $_SESSION["userLoggedIn"];
?>