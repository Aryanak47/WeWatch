<?php 
    require_once("includes/header.php");
    $entityProvider = new EntityProvider($conn, $userLoggedIn);
    $entities =  $entityProvider->getEntities(3,null);
    $sortByViews = "ORDER BY videos.views desc";
    $sortByNew = "ORDER BY videos.id desc";
    $newEntities =   $entityProvider->getMovieEntities(7,$sortByNew);
    $trendingEntities = $entityProvider->getMovieEntities(5,$sortByViews);
    $category = new Category($conn,$userLoggedIn);

?>
  
    <section id="home" class="iq-main-slider p-0">
      <div id="home-slider" class="slider m-0 p-0">
        <?php foreach ($entities as $entity): ?>
        <div class="slide slick-bg">
        <div class="trailer">
          <img src='<?= $entity->getThumbnail() ?>' class='previewImage' hidden />
          <video autoplay muted class='previewVideo' onended='previewEnded()'>
            <source src='<?= $entity->getPreview()?>' type='video/mp4'>
          </video>
          </div>
          <div class="container-fluid position-relative h-100">
            <div class="slider-inner h-100">
              <div class="row align-items-center h--100">
                <div class="col-xl-6 col-lg-12 col-md-12">
              
                  <a href="javascript:void(0)">
                    <div class="channel-logo" data-animation-in="fadeInLeft" data-delay-in="0.5">
                      <img src="assets/images/websitelogo.png" class="c-logo" alt="" />
                    </div>
                  </a>
                  <h1 class="slider-text big-title title text-uppercase" data-animation-in="fadeInLeft"
                    data-delay-in="0.6">
                    <?= $entity->getName()  ?>
                  </h1>
                  <div class="d-flex flex-wrap align-items-center fadeInLeft animated" data-animation-in="fadeInLeft"
                    style="opacity: 1">
                  
                    <div class="d-flex align-items-center mt-2 mt-md-3">
                      <?php 
                        $min = explode(":",$entity->getDuration())[0];
                      ?>
                      <span class="ml-3"><?= $min ?> Minutes </span>
                    </div>
                  </div>
                  <p data-animation-in="fadeInUp">
                      <?= $entity->getDescription() ?>
                  </p>
                  <div class="trending-list" data-animation-in="fadeInUp" data-delay-in="1.2">
                    <div class="text-primary title genres">
                      Genres : <span class="text-body"><?= $entity->getGenre() ?></span>
                    </div>
                  </div>
                  <div class="d-flex align-items-center  mt-4" data-animation-in="fadeInUp" data-delay-in="1.2">
                    <div class='buttons'>
                        <a href="entity.php?id=<?= $entity->getId() ?>" class="btn"><button><i class='fas fa-play' ></i> Play</button> </a>
                        <button onclick='volumeToggle(this)'><i class='fas fa-volume-mute'></i></button>
                    </div>
                  </div>
                </div>
              </div>
          
            </div>
          </div>
        </div>
        <?php endforeach ?>
      </div>
    </section>
    <div class="main-content">
      <section id="iq-upcoming-movie">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12 overflow-hidden">
                <div class="iq-main-header d-flex align-items-center justify-content-between">
                  <h4 class="main-title">New Movies</h4>
                </div>
                <div class="favorite-contens">
                  <ul class="favorites-slider list-inline row p-0 mb-0">
                    <?php foreach ($newEntities as $newEntity): ?>
                    <!-- slide item 1 -->
                    <li class="slide-item">
                      <div class="block-images position-relative">
                        <div class="img-box">
                          <img src='<?= $newEntity->getThumbnail() ?>' class="img-fluid" alt="" />
                        </div>
                        <div class="block-description">
                          <h6 class="iq-title">
                            <a href="#"> <?= $newEntity->getName() ?></a> </a>
                          </h6>
                          <div class="movie-time d-flex align-items-center my-2">
                          <?php 
                            $min = explode(":",$newEntity->getDuration())[0];
                          ?>
                            <span class="text-white"><?= $min ?> minutes</span>
                          </div>
                          <div class="hover-buttons">
                            <a href='entity.php?id=<?=$newEntity->getId() ?>' class='btn btn-hover iq-button'>
                              <span>
                                <i class="fa fa-play mr-1"></i>
                                Play Now
                              </span>
                            </a>
                          </div>
                        </div>
                        <div class="block-social-info">
                          <ul class="list-inline p-0 m-0 music-play-lists">
                            <li class="share">
                              <span><i class="fa fa-share-alt"></i></span>
                              <div class="share-box">
                                <div class="d-flex align-items-center">
                                  <a target="_blank" href="https://facebook.com/share.php?u=<?php echo $SITE_URL."/entity.php?id=".$newEntity->getId() ?>" class="share-ico"><i class="fa fa-facebook"></i></a>
                                  <a target="_blank" href="https://twitter.com/share?text=<?= $newEntity->getName()  ?> &url=<?php echo $SITE_URL."/entity.php?id=".$newEntity->getId() ?>" class="share-ico"><i class="fa fa-twitter"></i></a>
                                  <a target="_blank" href="https://api.whatsapp.com/send?text=<?= urlencode($newEntity->getName()) ?> <?php echo $SITE_URL."/entity.php?id=".$newEntity->getId() ?>" class="share-ico"><i class="fa fa-whatsapp"></i></a>
                                </div>
                              </div>
                            </li>
                            <li>
                            <?php 
                              $id = $newEntity->getId();
                              $query = $conn->prepare("SELECT * FROM wishlist WHERE user=:username AND entityId=:entity");
                              $query->bindParam(":entity",$id);
                              $query->bindParam(":username",$userLoggedIn);
                              $query->execute();
                              $wishlist = $query->rowCount() > 0;
                            
                            ?>
                            <span class="wish_list <?php echo $wishlist ? 'wish-active' : ''?>" data-info="<?php echo $userLoggedIn." ".$id;   ?>"><i class="fa fa-heart"></i></span>
                            </li>
                          
                          </ul>
                        </div>
                      </div>
                    </li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </section>
      <section id="iq-topten">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-12 overflow-hidden">
              <div class="topten-contents">
                <h4 class="main-title iq-title topten-title">
                  Trending Movies
                </h4>
                <ul id="top-ten-slider" class="list-inline p-0 m-0 d-flex align-items-center">
                <?php foreach ($trendingEntities as $trendingEntity): ?>
                  <li class="slick-bg">
                    <a href="#">
                      <img src="<?= $trendingEntity->getThumbnail() ?>" class="img-fluid w-100" alt="" />
                      <h6 class="iq-title"><a href="#"><?= $trendingEntity->getName() ?></a></h6>
                    </a>
                  </li>
                <?php endforeach ?>
                </ul>
                <div class="vertical_s">
                  <ul id="top-ten-slider-nav" class="list-inline p-0 m-0 d-flex align-items-center">
                    <?php foreach ($trendingEntities as $trendingEntity): ?>  
                      <li>
                        <div class="block-images position-relative">
                          <a href="#" class="img-box">
                            <img src="<?= $trendingEntity->getThumbnail() ?>" class="img-fluid w-100" alt="" />
                          </a>
                          <div class="block-description">
                            <h5><?= $trendingEntity->getName() ?></h5>
                            <div class="hover-buttons mt-2">
                              <a href="entity.php?id=<?= $trendingEntity->getId() ?>" class="btn btn-hover" tabindex="0">
                                <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                Play Now
                              </a>
                            </div>
                          </div>
                        </div>
                      </li>
                    <?php endforeach ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <?php echo $category->getCategories() ?>
      <?php 
        $newEntity = $newEntities[0];
        $min = explode(":",$newEntity->getDuration())[0];
      
      ?>
      <section id="parallex" class="parallax-window" style="background: url(<?= $newEntity->getThumbnail() ?>) center center;">
        <div class="container-fluid h-100">
          <div class="row align-items-center justify-content-center h-100 parallaxt-details">
            <div class="col-lg-4 r-mb-23">
              <div class="text-left">
                <a href="javascript:void(0)">
                  <h1 class="parallax-heading"><?= $newEntity->getName() ?></h1>
                </a>
                <div class="movie-time d-flex align-items-center mb-3">
                  <span class="text-white"><?= $min ?> minutes</span>
                </div>
                <p>
                  <?= $newEntity->getDescription() ?>
                </p>
                <div class="parallax-buttons">
                  <a href="entity.php?id=<?= $newEntity->getId() ?>" class="btn btn-hover">Play Now</a>
                </div>
              </div>
            </div>
            <div class="col-lg-8">
              <div class="parallax-img">
                <a href="#"><img src="<?= $newEntity->getThumbnail() ?>" alt="" class="img-fluid w-100" /></a>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <?php include_once("includes/footer.php") ?>

    
  </body>
</html>