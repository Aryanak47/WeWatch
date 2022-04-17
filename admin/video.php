<?php 
    require_once('../includes/config.php');    
    require_once('../includes/checkAdmin.php');
?>

<?php include 'top.inc.php'; ?>
    <div class="layout-container">
        <?php include 'side-nav.inc.php'; ?>
        <div class="main">
            <div class="d-flex justify-content-end">
                <?php include 'header.inc.php'; ?>
            </div>
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
                        <div class="col-md-8">
                            <div class="form-group">                  
                                <label for="video"><b>Video : <b></label>
                                <input type="file" name="video" id="video" class="form-control-file" required>  
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="cross_icon hidden">
                                <i class="fa fa-times" aria-hidden="true"></i>
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
    var ajaxCall;

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
        ajaxCall = new XMLHttpRequest();
        ajaxCall.upload.addEventListener("progress", progressHandler, false);
        ajaxCall.addEventListener("load", completeHandler, false);
        ajaxCall.addEventListener("error", errorHandler, false);
        ajaxCall.addEventListener("abort", abortHandler, false);
        ajaxCall.open("POST", "uploadVideo.php");
        ajaxCall.send(formdata);
        $(".cross_icon").toggleClass("hidden")
    }
    function progressHandler(event){
        $("#uploadBtn").text("Uploading....")
       
        // _("loaded_n_total").innerHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
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
        $(".cross_icon").toggleClass("hidden")
        $("#uploadBtn").text("Submit")
    }
    function abortHandler(event){
        _("status").innerHTML = "Upload Aborted";
        $(".cross_icon").toggleClass("hidden")
        $("#uploadBtn").text("Submit")
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

    $(document).on('click','.cross_icon', function(e){
        ajaxCall.abort();
        console.log("Canceled");
    });

</script>
<script src="js/script.js"></script>

</html>