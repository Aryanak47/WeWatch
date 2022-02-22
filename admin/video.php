<?php 
    require_once('../includes/config.php');    
    require_once('../includes/checkAdmin.php');
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
                    <div class="row">
                        <div class="col">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" placeholder="Title" id="title" name="title" value="" required>
                        </div>
                        <div class="col">
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
                    <div class="row">
                        <div class="col-md-6">
                            <label for="releaseDate">Release Date</label>
                            <input type="text" id="releaseDate" class="form-control" placeholder="2022-01-01" name="release" value="" required>
                        </div>
                      
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ismovie">Movie</label>
                                <select class="form-control" id="ismovie" name="ismovie" onChange="update()">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                
                    <div class="row movie-select" hidden>
                    <div class="form-group col-md-6">
                        <label for="season">Season</label>
                        <input type="text" class="form-control" id="season" placeholder="1" name="season" value="0" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="ep">Episodes</label>
                        <input type="text" class="form-control" id="ep" placeholder="1" name="ep" value="0" required>
                    </div>

                    </div>
                   
                
                    <div class="form-group">
                        <label  for="description">Description</label>
                        <input type="text" class="form-control" id="description" placeholder="description...." name="description" value="" required>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">                  
                                <label for="video"><b>Video : <b></label>
                                <input type="file" name="video" id="video" class="form-control-file" required>  
                            </div>
                        </div>
                    </div>
                
                    <progress id="progressBar" class="hidden" value="0" max="100" style="width:300px;"></progress>
                    <h3 id="status"></h3>
                    <p id="loaded_n_total"></p>
                    <div class="signupbutton">
                        <button type="button" onclick="uploadFile()" class ="btn btn-success btn-lg" id="uploadBtn" name="upload">Submit</button>
                    </div>
                    
                </form>
        </div>
    </div>

    
</body>
<script>
    function update(){
        console.log("change status")
        const ismovie =  $(".movie-select").prop("hidden")
        $(".movie-select").prop("hidden",!ismovie);
    }

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
        if(percent >= 100){
            _("status").innerHTML = "Converting file to mp4... please wait";
        }
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