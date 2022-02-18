<?php
    require_once('../includes/config.php');
    require_once('../includes/checkAdmin.php');
    if(!isset($_GET["id"])){
        header('Location:movies.php');
        die("Id needs to be provided !");
    
    }
    $id = $_GET["id"];
    $query = $conn->prepare("SELECT *,en.name AS moviename from entities  en  join categories c on en.categoryId=c.id WHERE en.id =:id ");
    $query->bindValue(':id',$id);
    $query->execute();
    $data = $query->fetch(PDO::FETCH_ASSOC);
    if(isset($_POST["submitBtn"])){
        $moviename = $_POST["moviename"];
        $category = $_POST["category"];
        
        $file  =  $data["thumbnail"];
        $f_name = $_FILES['image']['name'];
        if(!empty($f_name)){
            $f_temp = $_FILES["image"]["tmp_name"];
            $f_size = $_FILES["image"]["size"];
            $f_extension = explode('.',$f_name);
            $f_extension = strtolower(end($f_extension));
            $new_file = date('YmdHis') . uniqid().'.'.$f_extension;
            $file = $new_file;
            // delete the old file
            unlink("../".$data["thumbnail"]);
            $pathToUpload = "../entities/thumbnails/".$file;
            move_uploaded_file($f_temp,$pathToUpload);
            
        }
        $movie = $conn->prepare("UPDATE entities SET name=:nam,categoryId=:category,thumbnail=:thumbnail WHERE id = $id");
        $movie->bindValue(':nam',$moviename);
        $movie->bindValue(':category',$category);
        $movie->bindValue(':thumbnail',"entities/thumbnails/" . $file);
        $movie->execute();
        header("Location:movies.php");
        die();
    }







?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Movie</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <style>
        /* update movie */
        body{
            color: #fff;
            background-color: #000;
        }
        .row{
            margin:0;
        }

        #upload {
            opacity: 0;
        }

        #upload-label {
            position: absolute;
            top: 50%;
            left: 1rem;
            transform: translateY(-50%);
        }

        .image-area {
            border: 2px dashed rgba(255, 255, 255, 0.7);
            padding: 1rem;
            position: relative;
        }

    .image-area::before {
        content: 'Uploaded image result';
        color: #fff;
        font-weight: bold;
        text-transform: uppercase;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 0.8rem;
        z-index: 1;
    }

    .image-area img {
        z-index: 2;
        position: relative;
    }
    .video-info {
        display: flex;
        justify-content: space-around;
        align-items: center;
    }

    .video-container video {
        max-width: 80%;
    }

    .thumbnail-container {}

    .thumbnail-container img {
        width: 300px;
    }
    .breadcrumb{
        background-color: transparent !important;
    }



    </style>
</head>
<body>
   
    <div class="p-3 py-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="movies.php">Movies</a></li>
                <li class="breadcrumb-item active" aria-current="page">Movie Details</li>
            </ol>
        </nav>
        <div class="video-info">
            <div class="video-container">
                <h2 class="text-left">Update <?= $data["moviename"] ?></h4>
                <video controls>
                    <source src="../<?= $data["preview"] ?>">
                    Your browser does not support the video tag.
                </video>

            </div>
            <div class="thumbnail-container">
                <h2>Thumbnail</h2>
                <img src="../<?= $data["thumbnail"] ?>">
            </div>
        </div>
        <form method="post" enctype="multipart/form-data">
            <div class="row mt-2">
                <div class="col-md-12"><label class="labels">Name</label><input type="text" value="<?= $data["moviename"] ?>" class="form-control" placeholder="movie name" name="moviename"></div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                <select class="browser-default custom-select" name="category">
                    <option default value="<?= $data["categoryId"] ?>"><?= $data["name"] ?></option>
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
            <div class="row py-4">
                <div class="col-lg-6 mx-auto">

                    <!-- Upload image input-->
                    <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white shadow-sm">
                        <input id="upload" type="file"  onchange="readURL(this);" class="border-0" accept="image/png, image/gif, image/jpeg" name="image"/>
                        <label id="upload-label" for="upload" class="font-weight-light text-muted">Update Thumbnail</label>
                        <div class="input-group-append">
                            <label for="upload" class="btn btn-light m-0 rounded-pill px-4"> <i class="fa fa-cloud-upload mr-2 text-muted"></i><small class="text-uppercase font-weight-bold text-muted">Choose file</small></label>
                        </div>
                    </div>

                    <!-- Uploaded image area-->
                    <p class="font-italic text-white text-center">The image uploaded will be rendered inside the box below.</p>
                    <div class="image-area mt-4"><img id="imageResult" src="../<?= $data["thumbnail"] ?>" alt="" class="img-fluid rounded shadow-sm mx-auto d-block"></div>

                </div>
            </div> 
            <div class="mt-5 text-center"><input type="submit" name="submitBtn" class="btn btn-primary profile-button"></div>
         </form>
        </div>
    
</body>
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#imageResult')
                    .attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(function () {
        $('#upload').on('change', function () {
            readURL(input);
        });
    });

    /*  ==========================================
        SHOW UPLOADED IMAGE NAME
    * ========================================== */
    var input = document.getElementById( 'upload' );
    var infoArea = document.getElementById( 'upload-label' );

    input.addEventListener( 'change', showFileName );
    function showFileName( event ) {
    var input = event.srcElement;
    var fileName = input.files[0].name;
    infoArea.textContent = 'File name: ' + fileName;
}
</script>
</html>