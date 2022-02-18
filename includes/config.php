<?php 
    ob_start();
    session_start();
    $SITE_URL="http://localhost/wewatch";

    date_default_timezone_set('Asia/Kathmandu');
    try {
        $conn = new PDO("mysql:host=localhost;dbname=wewatch", "root", "");
        // set the PDO error mode to warning
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        // echo "Connected successfully";
      } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
      }


?>