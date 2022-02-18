<?php 
    require_once('../includes/config.php');  
    require_once('../includes/checkAdmin.php');
    
    if(isset($_FILES["video"])){
        $video_file  =  $_FILES["video"];
        $name = $_POST["name"];
        $desc = $_POST["description"];
        $ep = $_POST["ep"];
        $season = $_POST["season"];
        $movie = $_POST["ismovie"];
        $rel = $_POST["release"];
        $title = $_POST["title"];
        $title = ucfirst($title);
        $video_size = $video_file["size"];
        $query = $conn->prepare("SELECT * FROM videos where title=:title");
        $query->bindValue(':title',$title);
        $query->execute();
        if ($query->rowCount() > 0 ){
            $error = "<script>
            swal({
            title: 'Failed!',
            text: 'Movie with this name already exits.',
            icon: 'warning',
            button: 'Ok',
                });
            </script>";
            echo json_encode(array("msg"=>$error,"success"=>false));
            return;
        }
        
    
        // $video_type = $video_file["type"];
        $video_tmp = $video_file["tmp_name"];
        $video_name = $video_file["name"];
        $video_extension = explode('.',$video_name);
        $video_extension = strtolower(end($video_extension));
        $video_type = pathInfo($video_name,PATHINFO_EXTENSION);
        $allowedVideo = array("mp4","flv","ogg","vob","mov","mpeg","mpg","mkv","wmv","avi");
        if(in_array($video_type,$allowedVideo)){
            $folder = "../entities/videos/";
        //     // preview video should be equal or less than 2gb
            if($video_size <= 2147483648 ){
                $temp_file_path =  $folder.date('YmdHis') . uniqid().'.'.$video_extension;;
                if(move_uploaded_file($video_tmp,$temp_file_path)){
                    $final_file =date('YmdHis') . uniqid().'.mp4';
                    $final_file_path = $folder.$final_file;
                    if(!comvertVideoToMp4($temp_file_path,$final_file_path)){
                        return false;
                        $video_error =  "Could not convert video to mp4.";
                    }
                    if(!deleteFile($temp_file_path)){
                        return false;
                        $video_error =  "Could not delete the  file";

                    }
                    $duration = getVideoDuration($final_file_path);
                };   
            }else{
                $video_error = "video size is too large";
            }
        }else{
            $video_error  = "This video extension is not allowed !";
        }

        if(empty($video_error)){
            $success =  '<script>
                    swal({
                    title: "Sucess!",
                    text: " Video has been successfully Added !",
                    icon: "success",
                    button: "Ok",
                });
            </script>';
            
            $duration = date("H:i",strtotime($duration));
            $query = $conn->prepare("INSERT INTO videos (title,description,isMovie,releaseDate,duration,season,episode,entityId,filePath)
                                    VALUES(:title,:desc,:movie,:rel,:duration,:season,:episode,:entity,:filePath)");
            $query->bindValue(':title',$title);
            $query->bindValue(':desc',$desc);
            $query->bindValue(':movie',$movie);
            $query->bindValue(':rel',$rel);
            $query->bindValue(':duration',$duration);
            $query->bindValue(':season',$season);
            $query->bindValue(':episode',$ep);
            $query->bindValue(':entity',$name);
            $query->bindValue(':filePath',"entities/videos/".$final_file);
            $query->execute();
            if( $query->rowCount() > 0 ) {
                echo json_encode(array("msg"=>$success,"success"=>true));
            }else{
                $video_error = "Something went wrong uploading video try again later!";
            }
            
        }
        if(isset($video_error)){
            $error = "<script>
            swal({
            title: 'Failed!',
            text: '$video_error',
            icon: 'warning',
            button: 'Ok',
                });
            </script>";
            echo json_encode(array("msg"=>$error,"success"=>false));
        }
    
    }

    function comvertVideoToMp4($tempPath,$finalPath){
        $ffmpegPath = realpath("../ffmpeg/bin/ffmpeg.exe");
        $cmd = "$ffmpegPath -i $tempPath $finalPath 2>&1";
        $outputLogs = array();
        exec($cmd,$outputLog,$returnCode);
        if($returnCode!= 0){
            foreach($outputLog as $log){
                pr($log);
                return false;
            }

        }
        return true;
    }
    function deleteFile($path){
        if(!unlink($path)){
            return false;
        }
        return true;
    }
    function getVideoDuration($filePath){
        $ffprobe = realpath("../ffmpeg/bin/ffprobe.exe");
        return shell_exec("$ffprobe -v error -select_streams v:0 -show_entries stream=duration -of default=noprint_wrappers=1:nokey=1 -sexagesimal $filePath");

    }


?>