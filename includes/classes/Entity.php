<?php
class Entity {

    private $con, $sqlData,$video;

    public function __construct($con, $input) {
        $this->con = $con;

        if(is_array($input)) {
            $this->sqlData = $input;
        }
        else {
            $query = $this->con->prepare("SELECT entities.*,videos.* FROM entities INNER JOIN videos ON entities.id=videos.entityId WHERE entities.id=:id LIMIT 1");
            $query->bindValue(":id", $input);
            $query->execute();
            $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
        }
        

    }

    public function getId() {
        return $this->sqlData["entityId"];
    }

    public function getName() {
        return $this->sqlData["name"];
    }

    public function getThumbnail() {
        return $this->sqlData["thumbnail"];
    }

    public function getPreview() {
        return $this->sqlData["preview"];
    }
    public function getDescription() {
        return $this->sqlData["description"];
    }
    public function getDuration() {
        return $this->sqlData["duration"];
    }
    public function getCategoryId() {
        return $this->sqlData["categoryId"];
    }
    public function getSeasons() {
        $query = $this->con->prepare("SELECT * FROM videos WHERE entityId=:id
                                    AND isMovie=0 ORDER BY season, episode ASC");
        $query->bindValue(":id", $this->getId());
        $query->execute();

        $seasons = array();
        $videos = array();
        $currentSeason = null;
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            
            if($currentSeason != null && $currentSeason != $row["season"]) {
                $seasons[] = new Season($currentSeason, $videos);
                $videos = array();
            }

            $currentSeason = $row["season"];
            $videos[] = new Video($this->con, $row);

        }

        if(sizeof($videos) != 0) {
            $seasons[] = new Season($currentSeason, $videos);
        }

        return $seasons;
    }
 

}
?>