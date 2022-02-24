<?php
    require_once("includes/header.php");

?>
       <section id='iq-upcoming-movie' class='recent-movie'>
            <div class='container-fluid'>
              <div class='row'>
                <div class='col-sm-12 overflow-hidden'>
                  <div class='iq-main-header d-flex align-items-center justify-content-between'>
                    <h4 class='main-title mt-4'>Recently Watched</h4>
                  </div>
                    <div class='favorite-contens'>
                        <ul class='favorites-slider list-inline row p-0 mb-0'>
                            <?php
                                if(isset($_COOKIE['Recently_Watched'])){
                                    $results = [];
                                    $recentArrays = unserialize($_COOKIE['Recently_Watched']);
                                    $countRecentArrays = count($recentArrays);
                                    $start = $countRecentArrays-4;
                                    if($countRecentArrays > 4){
                                        $recentArrays = array_slice($recentArrays,$start,4);
                                    }
                                    $recentIds = implode(',',$recentArrays);
                                    $query = $conn->prepare("SELECT  * FROM entities where id IN ($recentIds) ");
                                    $query->execute();
                                    while ($row = $query->fetch(PDO::FETCH_ASSOC)){
                                        $results[] = $row;
                                    }
                                }

                            ?>
                            <?php foreach ($results as $entity){
                            $image =  $entity['thumbnail'];
                            $name =  $entity['name'];
                            $id = $entity['id'];
                            ?>
                            <li class='slide-item'>
                                <div class='block-images position-relative'>
                                    <div class='img-box'>
                                        <img src='<?= $image ?>' class='img-fluid' alt='' />
                                    </div>
                                    <div class='block-description'>
                                        <h6 class='iq-title'>
                                        <a href='#'> <?= $name ?> </a>
                                        </h6>
                                        <div class='hover-buttons'>
                                            <a href='entity.php?id=<?= $id ?>' class='btn btn-hover iq-button'>
                                                <i class='fa fa-play mr-1'></i>
                                                Play Now
                                            </a>
                                        </div>
                                    </div>
                                    <div class='block-social-info'>
                                        <ul class='list-inline p-0 m-0 music-play-lists'>
                                        <li class='share'>
                                            <span><i class='fa fa-share-alt'></i></span>
                                            <div class='share-box'>
                                            <div class='d-flex align-items-center'>
                                                <a href='#' class='share-ico'><i class='fa fa-share-alt'></i></a>
                                                <a href='#' class='share-ico'><i class='fa fa-youtube'></i></a>
                                                <a href='#' class='share-ico'><i class='fa fa-instagram'></i></a>
                                            </div>
                                            </div>
                                        </li>
                                        <li>
                                            <span><i class='fa fa-heart'></i></span>
                                        </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>     

                            <?php } ?>
                    
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>