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
        $movies =  $this->filterEntities($limit,$cond,true,false);
        return $movies;
        
    }
    public function getTvShowEntities($limit=3,$cond){
        $shows =  $this->filterEntities($limit,$cond,false,true);
        return $shows;

    }

    private function getRandomEntities($limit,$movies,$tvshows,$cat) {
        $result = array();
        $sql = "SELECT DISTINCT(videos.entityId) FROM entities INNER JOIN videos ON entities.id=videos.entityId";
        if($cat != null){
            $sql .= " where entities.categoryId = $cat";
        }
        $sql .= " ORDER BY RAND() LIMIT $limit";
        $query = $this->con->prepare($sql);
        $query->execute();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $result[] = new Entity($this->con, $row["entityId"]);
        }
        return $result;
    }
    private function filterEntities($limit,$cond,$movies=true,$tvshows=true) {
        $result = array();
        $sql = "SELECT DISTINCT(videos.entityId) FROM entities INNER JOIN videos ON entities.id=videos.entityId";
        if($movies && $tvshows) {
            $sql .= $sql;
        }elseif($tvshows) {
            $sql .= " where videos.isMovie=0";
        }else{
            $sql .= " where videos.isMovie=1";
        }
        if($cond != null){
            $sql .= " $cond" ;
        }
        $sql .= "  LIMIT $limit";
       
        $query = $this->con->prepare($sql);
        $query->execute();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $result[] = new Entity($this->con, $row["entityId"]);
        }
        return $result;
    }
    public static function getSearchEntities($con, $term) {

        $sql = "SELECT * FROM entities  WHERE name LIKE CONCAT('%', :term, '%') LIMIT 30";

        $query = $con->prepare($sql);

        $query->bindValue(":term", $term);
        $query->execute();

        $result = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Entity($con, $row);
        }

        return $result;
    }

}
?>