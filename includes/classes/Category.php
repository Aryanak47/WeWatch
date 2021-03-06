<?php 
    class Category{
        private $conn,$username;
        public function __construct($con,$username){
            $this->conn = $con;
            $this->username = $username;
        }

        public function getCategories(){
                $query = $this->conn->prepare("SELECT * FROM categories ORDER BY RAND() LIMIT 5");
                $query->execute();
                $categoryHtml = "";
                while($row = $query->fetch(PDO::FETCH_ASSOC)){
                    $categoryId = $row['id'];
                    $categoryTitle = $row['name'];
                    $entity= new EntityProvider($this->conn, $this->username);
                    $entities = $entity->getEntities(5,$categoryId);
                    $categoryHtml .= $this->getCategorySectionHtml($entities,$categoryTitle);
                }
                return $categoryHtml;

        }
        public function getTvShowsCategory(){
          $query = $this->conn->prepare("SELECT * FROM categories ORDER BY RAND()");
          $query->execute();
          $categoryHtml = "";
          while($row = $query->fetch(PDO::FETCH_ASSOC)){
              $categoryId = $row['id'];
              $categoryTitle = $row['name'];
              $entity= new EntityProvider($this->conn, $this->username);
              $cond = "and entities.categoryId=$categoryId";
              $entities = $entity->getTvShowEntities(7,$cond);
              $categoryHtml .= $this->getCategorySectionHtml($entities,$categoryTitle);
          }
          return $categoryHtml;

        }
        public function getMoviesCategory(){
          $query = $this->conn->prepare("SELECT * FROM categories ORDER BY RAND()");
          $query->execute();
          $categoryHtml = "";
          while($row = $query->fetch(PDO::FETCH_ASSOC)){
              $categoryId = $row['id'];
              $categoryTitle = $row['name'];
              $entity= new EntityProvider($this->conn, $this->username);
              $cond = "and entities.categoryId=$categoryId";
              $entities = $entity->getMovieEntities(7,$cond);
              $categoryHtml .= $this->getCategorySectionHtml($entities,$categoryTitle);
          }
          return $categoryHtml;

        }
        private function getCategorySectionHtml($entities,$title){
           if(empty($entities)){
               return "";
           }
           $SITE_URL = "http://127.0.0.1:80/wewatch";
           
            $html = "
            <section id='iq-upcoming-movie'>
            <div class='container-fluid'>
              <div class='row'>
                <div class='col-sm-12 overflow-hidden'>
                  <div class='iq-main-header d-flex align-items-center justify-content-between'>
                    <h4 class='main-title mt-4'>$title</h4>
                  </div>
                  <div class='favorite-contens'>
                    <ul class='favorites-slider list-inline row p-0 mb-0'>";
                    foreach ($entities as $entity){
                        $image =  $entity->getThumbnail();
                        $name =  $entity->getName();
                        $min = explode(':',$entity->getDuration())[0];
                        $id = $entity->getId();
                        $username = $this->username;
                        $urlEncoded = urlencode($name);
                        $query = $this->conn->prepare("SELECT * FROM wishlist WHERE user=:username AND entityId=:entity");
                        $query->bindParam(":entity",$id);
                        $query->bindParam(":username",$username);
                        $query->execute();
                        $wishlist = $query->rowCount() > 0;
                        $active =  $wishlist ? 'wish-active' : '';
                        $info = $username." ".$id;
                        $html .= "<li class='slide-item'>
                        <div class='block-images position-relative'>
                          <div class='img-box'>
                            <img src='$image' class='img-fluid' alt='' />
                          </div>
                          <div class='block-description'>
                            <h6 class='iq-title'>
                              <a href='#'> $name</a> </a>
                            </h6>
                            <div class='movie-time d-flex align-items-center my-2'>
                            
                              <span class='text-white'>$min  minutes</span>
                            </div>
                            <div class='hover-buttons'>
                              <a href='entity.php?id=$id' class='btn btn-hover iq-button'>
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
                                  
                                  <a target='_blank' href='https://facebook.com/share.php?u=$SITE_URL/entity.php?id=$id' class='share-ico'><i class='fa fa-facebook'></i></a>
                                  <a target='_blank' href='https://twitter.com/share?text=$urlEncoded&url=$SITE_URL/entity.php?id=$id' class='share-ico'><i class='fa fa-twitter'></i></a>
                                  <a target='_blank' href='https://api.whatsapp.com/send?text=$urlEncoded $SITE_URL/entity.php?id=$id' class='share-ico'><i class='fa fa-whatsapp'></i></a>
                                  </div>
                                </div>
                              </li>
                              <li>
                              <span class='wish_list $active' data-info='$info'><i class='fa fa-heart'></i></span>
                            </li>
                          
                              </li>
                            </ul>
                        </div>
                    </div>
                </li>";     
                    }
                $html .="</ul></div></div></div></div></section>";
                return $html;
        }
        public function getName($catid) {
            $query = $this->conn->prepare('SELECT * from categories where id=:id');
            $query->bindValue(":id", $catid);
            $query->execute();
            $sqlData = $query->fetch(PDO::FETCH_ASSOC);
            return $sqlData["name"];
        }
    
    }



?>