<?php
    require_once("includes/header.php");

    if(!isset($_GET["id"])) {
        ErrorMessage::show("No ID passed into page");
    }
    $entityId = $_GET["id"];
    $entity = new Entity($conn, $entityId);
    $id = $entity->getId();
    $videoId = VideoProvider::getEntityVideoForUser($conn, $id, $userLoggedIn);
    $video = new Video($conn, $videoId);
    $continue = $video->isInProgress($userLoggedIn);
    $playText = $continue ? "Continue Waiting":"Play";
    $seasonEpisode = $video->getSeasonAndEpisode();
    $subHeading = $video->isMovie() ? "" : "<h4>$seasonEpisode</h4>";
    $seasonProvider = new SeasonProvider($conn, $userLoggedIn);
    
?>
     <div id="home-slider" class="slider m-0 p-0">
        <div class="slide slick-bg">
        <div class="trailer">
          <img src='<?= $video->getThumbnail() ?>' class='previewImage' hidden />
          <video autoplay muted class='previewVideo' onended='previewEnded()'>
            <source src='<?= $video->getPreview()?>' type='video/mp4'>
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
                    <?= $video->getTitle()  ?>
                  </h1>
                  <?= $subHeading ?>
                  <div class="d-flex flex-wrap align-items-center fadeInLeft animated" data-animation-in="fadeInLeft"
                    style="opacity: 1">
                  
                    <div class="d-flex align-items-center mt-2 mt-md-3">
                      <?php 
                        $min = explode(":",$video->getDuration())[0];
                      ?>
                      <span class="ml-3"><?= $min ?> Minutes </span>
                    </div>
                  </div>
                  <p data-animation-in="fadeInUp">
                      <?= $video->getDescription() ?>
                  </p>
                  <div class="trending-list" data-animation-in="fadeInUp" data-delay-in="1.2">
                    <div class="text-primary title genres">
                      Genres : <span class="text-body">Action</span>
                    </div>
                  </div>
                  <div class="d-flex align-items-center  mt-4" data-animation-in="fadeInUp" data-delay-in="1.2">
                    <div class='buttons'>
                        <button onclick="watchVideo(<?php echo $video->getID(); ?>)"><i class='fas fa-play' ></i> <?= $playText ?></button>
                        <button onclick='volumeToggle(this)'><i class='fas fa-volume-mute'></i></button>
                    </div>
                  </div>
                </div>
              </div>
          
            </div>
          </div>
        </div>
      </div>
    <?php echo $seasonProvider->create($entity); ?>
    <?php 
      if(isset($_COOKIE['Recently_Watched'])){
        $recent = unserialize($_COOKIE['Recently_Watched']);
        if(($key = array_search($entityId,$recent)) != false){
          unset($recent[$key]);
        }
        $recent[] = $entityId;
        setcookie('Recently_Watched', serialize($recent), time()+60*60*24*365);
      }else{
        $recent[] = $entityId;
        setcookie('Recently_Watched', serialize($recent), time()+60*60*24*365);
      }
        ?>
        <div class="recommendation-section">
          <h2 class="d-flex justify-content-center m-4 display-4 font-weight-bold">Recommended For You</h2>
          <div class="loader" style="display: none; position:unset !important">
            <img src="assets/images/load.gif" alt="loader" />
          </div>
        </div>
        <div class="results"></div>
        <script>
          let title = "<?php echo $entity->getName(); ?>"
           getRecommendations(title);
        </script>
  </body>
</html>
