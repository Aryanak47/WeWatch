<?php
    require_once('../includes/config.php');
    require_once('../includes/checkAdmin.php');


    if(isset($_POST["upload"])){

        
        $video_file  =  $_FILES["video"];
        $image_file  =  $_FILES["image"];
        $name = $_POST["name"];
        $category = $_POST["category"];

        // image info
        $img_info = getimagesize($image_file["tmp_name"]);
        $img_size = $image_file["size"];
        $img_tmp = $image_file["tmp_name"];
        $img_name = $image_file["name"];
        $img_extension = explode('.',$img_name);
        $img_extension = strtolower(end($img_extension));
        $allowedImage = array("image/png", "image/jpeg", "image/gif", "image/jpg");
        $image_error = "";

        if(in_array($img_info["mime"],$allowedImage)){
              // thumbnail image should be equal or less than 30 mb
            if($img_size <= 10485760){
                $i_file = date('YmdHis') . uniqid().'.'.$img_extension;
                $img_file = $i_file;
                $pathToUpload = "../entities/thumbnails/".$img_file;
                move_uploaded_file($img_tmp,$pathToUpload);
            }else {
                # code...
                $image_error =  "too large";
            }
        }else{
            $image_error =  "This image extension not allowed !";
            
        }
        echo $image_error;

        $video_size = $video_file["size"];
        $video_type = $video_file["type"];
        $video_tmp = $video_file["tmp_name"];
        $video_name = $video_file["name"];
        $video_extension = explode('.',$video_name);
        $video_extension = strtolower(end($video_extension));
        $allowedVideo = array("video/mp4");
        
        $video_error = "";
        if(in_array($video_type,$allowedVideo)){
            // preview video should be equal or less than 30 mb
            if($video_size <= 31457280){
                $v_file = date('YmdHis') . uniqid().'.'.$video_extension;
                $file = $v_file;
                $videoToUpload = "../entities/previews/".$file;
                move_uploaded_file($video_tmp,$videoToUpload);
            }else {
                # code...
                $video_error = "video size is too large";
            }
        }else{
            $video_error  = "This video extension is not allowed !";
        }
        echo $video_error;
        if(empty($video_error) && empty($image_error)){
            $query = $conn->prepare("INSERT INTO entities(name,categoryId,thumbnail,preview)VALUES(:nam,:cat,:thumbnail,:preview)");
            $query->bindValue(':nam',$name);
            $query->bindValue(':cat',$category);
            $query->bindValue(':thumbnail',"entities/thumbnails/" . $img_file);
            $query->bindValue(':preview',"entities/previews/" . $file);
            $query->execute();
            if( $query->rowCount() > 0 ) {
                $msg =  "
                <script>
                swal('Success!', 'New Entity Added Successfully!', 'success')
                </script>";
                ;
            }else{
                $msg =  "
                <script>
                swal('Failed!', 'Something went wrong!', 'warning')
                </script>";
                ;

            }
            
        }
    }






?>




<?php include 'top.inc.php'; ?>
    <div class="layout-container">
        <?php include 'side-nav.inc.php'; ?>
        <div class="main">
        <header class="header d-flex justify-content-end ">
                <nav class="user-nav">
                    <div class="user-nav__user dropdown">
                        <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="img/user-1.jpg" alt="User photo" class="user-nav__user-photo">
                            <span class="user-nav__user-name">Admin</span>
                        </div>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a href="video.php" class="dropdown-item"> 
                            <i class="fa fa-upload" aria-hidden="true"></i> <span>Upload Video</span>
                        </a>
                        <a href="userProfile.php" class="dropdown-item">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>Logout</span>
                        
                        </a>
                        </div>
                    </div>

                </nav>
            </header>
            <?php if (isset($msg)) {
                echo $msg;
            } ?>
            <div class="container">
                <h1> Add Entitiy </h1>
                <form class="box py-2" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Name</label>
                        <input type="text" class="form-control" placeholder="Title" name="name" value="" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                        <select class="browser-default custom-select" name="category">
                            <?php
                                $queryCategory = $conn->prepare("SELECT * FROM categories");
                                $queryCategory->execute();
                                $categories = $queryCategory->fetchAll();
                                foreach ($categories as $category) {
                                ?>
                                    <option value=<?= $category["id"] ?>><?= $category["name"] ?></option>
                                <?php
                                }
                                ?>
                        </select>
                        </div>
                    </div>

                    <div class="row">
                    <div class="col">
                        <table>
                        <tr>
                            <td> <label for=""><b>Thumbnail : </b></label> </td>
                            <td>
                                <div>
                                    <input type="file" name="image" required>
                                </div>
                            </td>
                        </tr>
                        </table>
                    </div>
                    <div class="col">
                        <table>
                        <tr>
                            <td> <label for=""><b>Preview Video : </b></label> </td>
                            <td>
                                <div>
                                    <input type="file" name="video"  required>
                                </div>
                            </td>
                        </tr>
                        </table>

                    </div>
                    </div> <br><br>
                    <div class="signupbutton">
                        <input type="submit" class ="btn btn-success btn-lg" name="upload" value="Submit" >
                    </div>
                </form>
        </div>
        </div>
    </div>
    
</body>
<script src="js/script.js"></script>

</html>