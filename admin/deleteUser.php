<?php 
    require_once("../includes/classes/Config.php");
    if(isset($_GET["id"])){
        $userid = $_GET["id"];
        $query = $conn->prepare("UPDATE users SET ban = CASE WHEN ban = 1 THEN 0 ELSE 1 END WHERE id =:id");
        $query->bindValue(':id',$userid);
        $query->execute();
       header("Location:index.php");
       die();
        
    }




?>