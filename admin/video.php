<?php 
    require_once('../includes/config.php');    
    require_once('../includes/checkAdmin.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video</title>
    <!-- <link rel="shortcut icon" type="image/png" href="img/favicon.png"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
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
                            <a href="userProfile.php" class="dropdown-item">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <span>Profile</span>
                            
                            </a>
                            <a href="uploadMovie.php" class="dropdown-item"> 
                                <i class="fa fa-upload" aria-hidden="true"></i> <span>Upload Movie</span>
                            </a>
                            <a href="uploadSeries.php" class="dropdown-item">
                                <i class="fa fa-upload" aria-hidden="true"></i>
                                <span>Upload Series</span>
                            </a>
                        </div>
                    </div>

                </nav>
            </header>
            <div class="container">
                <h1> Add Video </h1>
                <form class="box py-2" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" placeholder="Title" id="title" name="title" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="releaseDate">Release Date</label>
                        <input type="text" id="releaseDate" class="form-control" placeholder="2022-01-01" name="release" value="" required>
                    
                    </div>
                    <div class="form-group">
                        <label for="ismovie">Movie</label>
                        <select class="form-control" id="ismovie" name="ismovie">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                   
                    <div class="form-group">
                        <label for="season">Season</label>
                        <input type="text" class="form-control" id="season" placeholder="1" name="season" value="0" required>
                    </div>
                    <div class="form-group">
                        <label for="ep">Episodes</label>
                        <input type="text" class="form-control" id="ep" placeholder="1" name="ep" value="0" required>
                    </div>
                    <div class="form-group">
                        <label  for="description">Description</label>
                        <input type="text" class="form-control" id="description" placeholder="description...." name="description" value="" required>
                    </div>
             
                
               
                    <div class="row mb-3">
                        <div class="col-md-12">
                        <label class="" for="name">Name</label>
                        <select class="browser-default custom-select" id="name" name="name">
                        <?php
                            $queryEn = $conn->prepare("SELECT * FROM entities");
                            $queryEn->execute();
                            $ens = $queryEn->fetchAll();
                            foreach ($ens as $en) {
                            ?>
                                <option value=<?= $en["id"] ?>><?= $en["name"] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        </div>
                    </div>
                    <div class="form-group">                  
                        <label for="video">Video</label>
                        <input type="file" name="video" id="video" class="form-control-file" required>  
                    </div>
                    <progress id="progressBar" class="hidden" value="0" max="100" style="width:300px;"></progress>
                    <h3 id="status"></h3>
                    <p id="loaded_n_total"></p>
                   <br><br>
                    <div class="signupbutton">
                        <button type="button" onclick="uploadFile()" class ="btn btn-success btn-lg" id="uploadBtn" name="upload">Submit</button>
                    </div>
                    
                </form>
        </div>
    </div>

    
</body>
<script>

    function _(el){
        return document.getElementById(el);
    }
    function uploadFile(){
        $(".error").remove();
        console.log("Uploading file...");
        var file = _("video").files[0];
        var title = _("title").value;
        var release = _("releaseDate").value;
        var ismovie = _("ismovie").value
        var season = _("season").value
        var description = _("description").value
        var name = _("name").value
        var ep = _("ep").value
        if(!checkInput(name,description,release,title,file)){
            return;
        }
        // alert(file.name+" | "+file.size+" | "+file.type);
        var formdata = new FormData();
        formdata.append("video", file);
        formdata.append("title", title);
        formdata.append("release", release);
        formdata.append("ismovie", ismovie);
        formdata.append("season", season);
        formdata.append("description", description);
        formdata.append("name", name);
        formdata.append("ep", ep);
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        ajax.open("POST", "uploadVideo.php");
        ajax.send(formdata);
    }
    function progressHandler(event){
        $("#uploadBtn").text("Uploading....")
        _("loaded_n_total").innerHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
        var percent = (event.loaded / event.total) * 100;
        _("progressBar").classList.remove("hidden");
        _("progressBar").value = Math.round(percent);
        _("status").innerHTML = Math.round(percent)+"% uploaded... please wait";
        console.log(percent);
    }
    function completeHandler(event){
        $("#status").html("")
        let response = JSON.parse(event.target.responseText)
        _("progressBar").value = 0;
        _("progressBar").classList.add("hidden");
        $("#uploadBtn").text("Submit")
        if(response.success){
            $("#status").append(response.msg);
            clearInput()
        }else{
            $("#status").append(response.msg);
        }       
    }
    function errorHandler(event){
        _("status").innerHTML = "Upload Failed";
    }
    function abortHandler(event){
        _("status").innerHTML = "Upload Aborted";
    }
    function checkInput(name,description,release,title,file){
        let error = document.createElement("span")
        error.classList.add("error");
        if(!title){
           error.textContent = "Please enter a title";
           $("#title").parent().append(error)
           $("#title").focus();
           return false;

       }
     
        if(!release){
            error.textContent = "Please enter a release date";
           $("#releaseDate").parent().append(error)
           $("#releaseDate").focus();
           return false;

       }
        if(!description){
            error.textContent = "Please enter a description of the video";
           $("#description").parent().append(error)
           $("#description").focus();
           return false;      

       }
        if(!file){
            error.textContent = "Please upload a video file";
           $("#video").parent().append(error)
           $("#video").focus();
           return false;      
       }
       return true;
    }
    function clearInput(){
        $("#title").val('');
        $("#video").val('');
        $("#releaseDate").val('');
        $("#description").val('');
    }

</script>
<script src="js/script.js"></script>

</html>