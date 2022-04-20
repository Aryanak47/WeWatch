<?php
class Video {
    private $con, $sqlData, $entity;

    public function __construct($con, $input) {
        $this->con = $con;

        if(is_array($input)) {
            $this->sqlData = $input;
        }
        else {
            $query = $this->con->prepare("SELECT * FROM videos WHERE id=:id");
            $query->bindValue(":id", $input);
            $query->execute();

            $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
        }

        $this->entity = new Entity($con, $this->sqlData["entityId"]);
    }
    
  

    public function getSeasonNumber() {
        return $this->sqlData["season"];
    }

    public function getId() {
        return $this->sqlData["id"];
    }
    public function getEntityId() {
        return $this->sqlData["entityId"];
    }

    public function getTitle() {
        return $this->sqlData["title"];
    }

    public function getGenre() {
        return $entity->getGenre();
    }

    public function getDescription() {
        return $this->sqlData["description"];
    }

    public function getFilePath() {
        return $this->sqlData["filePath"];
    }

    public function getThumbnail() {
        return $this->entity->getThumbnail();
    }
    public function getPreview() {
        return $this->entity->getPreview();
    }
    public function getDuration() {
        return $this->sqlData["duration"];
    }

    public function getEpisodeNumber() {
        return $this->sqlData["episode"];
    }
    public function incrementViews() {
        $query = $this->con->prepare("UPDATE videos SET views=views+1 WHERE id=:id");
        $query->bindValue(":id", $this->getId());
        $query->execute();
    }

    public function isInProgress($user){
        $query = $this->con->prepare("SELECT * from videoprogress where username=:username
                                     and videoId = :videoId and finished =0");
        $query->bindValue(":videoId", $this->getId());
        $query->bindValue(":username", $user);
        $query->execute();
        return $query->rowCount() != 0;



    }
    public function hasSeen($user){
        $query = $this->con->prepare("SELECT * from videoprogress where username=:username
                                     and videoId = :videoId and finished =1");
        $query->bindValue(":videoId", $this->getId());
        $query->bindValue(":username", $user);
        $query->execute();
        return $query->rowCount() != 0;
    }

    public function getSeasonAndEpisode() {
        if($this->isMovie()) {
            return;
        }

        $season = $this->getSeasonNumber();
        $episode = $this->getEpisodeNumber();

        return "Season $season, Episode $episode";
    }

    public function isMovie() {
        return $this->sqlData["isMovie"] == 1;
    }
}
?>