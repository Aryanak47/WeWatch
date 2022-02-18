<?php
class EntityProvider {

    private $con, $username;

    public function __construct($con, $username) {
        $this->con = $con;
        $this->username = $username;
    }

    public function getEntities($limit=3,$cat) {
        $entities = $this->getRandomEntities($limit,true,true,$cat);
        return $entities;
    }

    public function getMovieEntities($limit=3,$cond){
        return $this->filterEntities($limit,$cond,true,false);
        
    }
    public function getTvShowEntities($limit=3,$cond){
        return filterEntities($limit,$cond,false,true);

    }

    private function getRandomEntities($limit,$movies,$tvshows,$cat) {
        $result = array();
        $sql = "";
        if($movies && $tvshows) {
            $sql .= "SELECT entities.*,videos.* FROM entities INNER JOIN videos ON entities.id=videos.entityId";
        }elseif($tvshows) {
            $sql .= "SELECT entities.*,videos.* FROM entities INNER JOIN videos ON entities.id=videos.entityId where videos.isMovie=0";
        }else{
            $sql .= "SELECT entities.*,videos.* FROM entities INNER JOIN videos ON entities.id=videos.entityId where videos.isMovie=1";

        }
        if($cat != null){
            $sql .= " where entities.categoryId = $cat";
        }
        $sql .= " ORDER BY RAND() LIMIT $limit";
        $query = $this->con->prepare($sql);
        $query->execute();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $result[] = new Entity($this->con, $row);
        }
        return $result;
    }
    private function filterEntities($limit,$cond,$movies=true,$tvshows=true) {
        $result = array();
        $sql = "";
        if($movies && $tvshows) {
            $sql .= "SELECT entities.*,videos.* FROM entities INNER JOIN videos ON entities.id=videos.entityId";
        }elseif($tvshows) {
            $sql .= "SELECT entities.*,videos.* FROM entities INNER JOIN videos ON entities.id=videos.entityId where videos.isMovie=0";
        }else{
            $sql .= "SELECT entities.*,videos.* FROM entities INNER JOIN videos ON entities.id=videos.entityId where videos.isMovie=1";
        }
        if($cond != null){
            $sql .= " $cond " ;
        }
        $sql .= " LIMIT $limit";
       
        $query = $this->con->prepare($sql);
        $query->execute();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $result[] = new Entity($this->con, $row);
        }
        return $result;
    }

}
?>