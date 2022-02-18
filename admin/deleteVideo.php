<?php 
    require_once("../includes/config.php");
    if(isset($_GET["id"])){
        $videoid = $_GET["id"];
        $page = $_GET["page"];
        echo $videoid;
        $query = $conn->prepare("DELETE from videos where id = $videoid");
        $query->execute();
       header("Location:movies.php");
       die();
        
    }
?>