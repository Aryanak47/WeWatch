<?php
    require_once("includes/header.php");
    $query = $conn->query("SELECT * FROM wishlist where user = $userLoggedIn ORDER BY createdAt desc");
    $query->execute();
    $datas = $query->fetchAll();
    $entities = array();
    foreach ($datas as $data){
        $entities[] =new Entity($conn, $data["entityId"]);
    }

?>
    <section class='wish-section'>
        <div class='container-fluid'>
            <div class='row'>
            <div class='col-sm-12 overflow-hidden'>
                <div class='iq-main-header d-flex align-items-center justify-content-between'>
                <h4 class='main-title mt-4'>My wish list</h4>
                </div>
                <div class='favorite-contens'>
                    <ul class='favorites-slider list-inline row p-0 mb-0'>
                        <?php foreach ($entities as $entity){
                        $image =  $entity->getThumbnail();
                        $name =  $entity->getName();
                        $id = $entity->getId();
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
                                            <a target="_blank" href="https://facebook.com/share.php?u=<?php echo $SITE_URL."/entity.php?id=".$id ?>" class="share-ico"><i class="fa fa-facebook"></i></a>
                                            <a target="_blank" href="https://twitter.com/share?text=<?= $name  ?> &url=<?php echo $SITE_URL."/entity.php?id=".$id ?>" class="share-ico"><i class="fa fa-twitter"></i></a>
                                            <a target="_blank" href="https://api.whatsapp.com/send?text=<?= urlencode($name) ?> <?php echo $SITE_URL."/entity.php?id=".$id ?>" class="share-ico"><i class="fa fa-whatsapp"></i></a>
                                        </div>
                                        </div>
                                    </li>
                                    <li>
                                        <?php 
                                            $query = $conn->prepare("SELECT * FROM wishlist WHERE user=:username AND entityId=:entity");
                                            $query->bindParam(":entity",$id);
                                            $query->bindParam(":username",$userLoggedIn);
                                            $query->execute();
                                            $wishlist = $query->rowCount() > 0;
                                        
                                        ?>
                                        <span class="wish_list wish-btn <?php echo $wishlist ? 'wish-active' : ''?>" data-info="<?php echo $userLoggedIn." ".$id;   ?>"><i class="fa fa-heart"></i></span>
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
<?php if(count($entities) == 0) {
    echo "<h2 class='d-flex justify-content-center'> Nothing to show</h2>";
} ?>
</section>
<script>
 $(".wish-btn").click(function (){
     $(".div1").remove();
     let el = $(this).closest(".slide-item")
     $(el).remove();
 })

</script>
