<?php 
    require_once("../includes/classes/Config.php");
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