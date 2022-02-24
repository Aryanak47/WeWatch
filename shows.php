<?php
    require_once("includes/header.php");


    $entityProvider = new EntityProvider($conn, $userLoggedIn);
    $tvEntities =   $entityProvider->getTvShowEntities(1,"ORDER BY RAND()")[0];
    $category = new Category($conn,$userLoggedIn); 
?>
     <div id="home-slider" class="slider m-0 p-0">
        <div class="slide slick-bg">
        <div class="trailer">
          <img src='<?= $tvEntities->getThumbnail() ?>' class='previewImage' hidden />
          <video autoplay muted class='previewVideo' onended='previewEnded()'>
            <source src='<?= $tvEntities->getPreview()?>' type='video/mp4'>
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
                    <?= $tvEntities->getName()  ?>
                  </h1>
                  <div class="d-flex flex-wrap align-items-center fadeInLeft animated" data-animation-in="fadeInLeft"
                    style="opacity: 1">
                  
                    <div class="d-flex align-items-center mt-2 mt-md-3">
                      <?php 
                        $min = explode(":",$tvEntities->getDuration())[0];
                      ?>
                      <span class="ml-3"><?= $min ?> Minutes </span>
                    </div>
                  </div>
                  <p data-animation-in="fadeInUp">
                      <?= $tvEntities->getDescription() ?>
                  </p>
                  <div class="trending-list" data-animation-in="fadeInUp" data-delay-in="1.2">
                    <div class="text-primary title genres">
                      Genres : <span class="text-body">Action</span>
                    </div>
                  </div>
                  <div class="d-flex align-items-center  mt-4" data-animation-in="fadeInUp" data-delay-in="1.2">
                    <div class='buttons'>
                        <a href="entity.php?id=<?= $tvEntities->getId() ?>" class="btn"><button><i class='fas fa-play' ></i> Play</button> </a>
                        <button onclick='volumeToggle(this)'><i class='fas fa-volume-mute'></i></button>
                    </div>
                  </div>
                </div>
              </div>
          
            </div>
          </div>
        </div>
      </div>
     <?php echo $category->getTvShowsCategory(); ?>
  </body>
</html>
