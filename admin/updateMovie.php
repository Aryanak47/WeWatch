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

<?php include 'top.inc.php'; ?>
    <div class="layout-container">
        <?php include 'side-nav.inc.php'; ?>
        <div class="main">
            <div class="d-flex justify-content-end">
                    <?php include 'header.inc.php'; ?>
            </div>
       
            <div class="p-3 py-5 update-movie">
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
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label class="labels">Name</label>
                        <input type="text" value="<?= $data["moviename"] ?>" class="form-control" placeholder="movie name" name="moviename">
                    </div>
                    <div class="col-md-6">
                        <label class="labels">Category </label>
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
                <div class="mt-2 text-center"><input type="submit" name="submitBtn" class="btn btn-primary profile-button"></div>
            </form>
        </div>



        </div>
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