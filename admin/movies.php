
<?php 



// 74-30 == 44
   require_once('../includes/classes/config.php');
   require_once('../includes/classes/FormSanitizer.php');
   $title = "Movies";
   $limit = 8;
   $page = isset($_GET['page']) ? $_GET['page'] :1;
    $start = ($page -1) * $limit;
   $srch = "";
   $sort = "";
 
   if(isset($_GET['search'])){
       echo $_GET["search"];
        $search = $_GET['search'];
        $search = FormSanitizer::sanitizeInput($search);
        $srch = $search;
    }
   if(isset($_GET['sort'])){
        $srt = strip_tags($_GET['sort']);
        $srt = trim($srt);
       if($srt === "lviews"){
            $sort = " ORDER BY videos.views asc";

       }elseif($srt === "mviews"){
           $sort = " ORDER BY videos.views desc";
       }else{
            $sort = " ORDER BY videos.id desc";

       }
    }
 
   $videos = getVideos($conn,$start,$limit,$sort,$srch);
   $totalFetch = count($videos);
   $query = $conn->prepare("SELECT  DISTINCT entities.name FROM videos INNER JOIN entities ON videos.entityId=entities.id where IsMovie=1");
   $query->execute();
   $total = $query->fetchAll();
   $total =count($total);
   $previous = $page > 1 ? $page -1:1;
   $next = $page +1;
   $totalPages = ceil($total/$limit);

   function getVideos($conn,$start,$limit,$sort,$search){
        $queryStr = "SELECT  DISTINCT entities.name,  entities.id, videos.views, videos.id as vid  FROM videos 
        INNER JOIN entities ON videos.entityId=entities.id where IsMovie=1";
        if($search != '') {
            $queryStr .= " and entities.name LIKE '%$search%' OR videos.title LIKE '%$search%' ";
        }
        if($sort != '') {
            $queryStr .= $sort;
        }else{
            $queryStr .= " ORDER BY videos.id desc ";
        }
        // echo $queryStr;
        $queryStr .= " LIMIT  $start,  $limit";
        $query = $conn->prepare($queryStr);
        $query->execute();
        return $query->fetchAll();
   }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet">
    <!-- <link rel="shortcut icon" type="image/png" href="img/favicon.png"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="css/style.css">
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>Admin Dashboard</title>

</head>
<body>
    <div class="layout-container">
        <?php include 'side-nav.php'; ?>
        <div class="main">
            <?php include 'header.php'; ?>
            <main class="video-info">
                <h2 class="title py-4">Manage Movies</h2>
                <div class="d-flex flex-row">
                    <div class="text-muted m-2" id="res">Showing <?= $totalFetch ?> results</div>
                    <div class="ml-auto mr-lg-4">
                        <div id="sorting" class="border rounded p-1 m-1"> <span class="text-muted">Sort by</span>
                            <select name="sort" onchange="sortByValue('movies')" id="sort">
                                <?php $hasSort = isset($_GET['sort']) ?>
                                <option value="nmovie" <?=   $hasSort && $_GET['sort'] ==  'nmovie' ?  "selected" : ''; ?>><b>New <?= $title ?></b></option>
                                <option value="mviews" <?=  $hasSort && $_GET['sort'] == 'mviews' ?  "selected" : ''; ?>><b>More Views</b></option>
                                <option value="lviews" <?=  $hasSort && $_GET['sort'] == 'lviews' ?  "selected" : ''; ?>><b>Less Views</b></option>
                                    
                            </select>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Title</th>						
                            <th>Views</th>
                            <th>Actions</th>
                        
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php foreach ($videos as $video):?>
                            <td><?= $video["id"]?></td>
                            <td><?= $video["name"]?></td>
                            <td><?= $video["views"]?></td>
                            <td class="video-actions">
                                <a href="updateMovie.php?id=<?= $video["id"] ?>"  title="Update" data-toggle="tooltip"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <a href='deleteVideo.php?id=<?= $video["vid"] ?>&page="movies.php"'  title="Delete" data-toggle="tooltip"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="clearfix">
                    <?php if($totalFetch > 0): ?>
                    <div class="hint-text">Showing <b> <?= $totalFetch ?> </b> out of <b><?= $total ?></b> entries</div>
                    <ul class="pagination">
                        <li class="page-item <?php if($previous == 1) echo "disabled"  ?>"  ><a href="movies.php?page=<?= $previous ?>">Previous</a></li>
                    <?php for($i = 1; $i <= $totalPages;$i++): ?>
                            <li class="page-item <?php  if($i == $_GET['page']) echo "active" ?>"><a href="movies.php?page=<?= $i ?>" class="page-link"><?= $i ?></a></li>
                            <?php endfor; ?>
                            <li class="page-item"><a href="movies.php?page=<?= $next ?>" class="page-link">Next</a></li>
                    </ul>
                </div>
                <?php endif; ?>

                </main>
            </div>
    </div>
</body>
<script src="js/script.js"></script>
</html>