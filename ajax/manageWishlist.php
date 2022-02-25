<?php
require_once("../includes/config.php");

if(isset($_POST["entity"]) && isset($_POST["user"])) {

    $query = $conn->prepare("SELECT * FROM wishlist 
                            WHERE user=:username AND entityId=:entity");
    $query->bindValue(":username", $_POST["user"]);
    $query->bindValue(":entity", $_POST["entity"]);
    $query->execute();

    if($query->rowCount() == 0) {
        
        $query = $conn->prepare("INSERT INTO wishlist (user, entityId)
                                VALUES(:username, :entity)");
        $query->bindValue(":username", $_POST["user"]);
        $query->bindValue(":entity", $_POST["entity"]);
        $query->execute();
        echo 1;
        
    }else{
        $query = $conn->prepare("DELETE FROM  wishlist where user=:user and entityId=:entity");
        $query->bindValue(":user", $_POST["user"]);
        $query->bindValue(":entity", $_POST["entity"]);
        $query->execute();
        echo 0;
    }
}
else {
    echo "No videoId or username passed";
}
?>