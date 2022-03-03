<?php
class SearchResultsProvider {

    private $con, $username;

    public function __construct($con, $username) {
        $this->con = $con;
        $this->username = $username;
    }

    public function getResults($inputText) {
        $entities = EntityProvider::getSearchEntities($this->con, $inputText);
        $html = "<div class='previewCategories noScroll'>";
        if(count($entities) < 1){
            $html .= "<h2> No results found</h2></div>";
            return $html;

        }

        $html = "<div class='previewCategories noScroll'>";

        $html .= $this->getResultHtml($entities);

        return $html . "</div>";
    }

    private function getResultHtml($entities) {
        if(sizeof($entities) == 0) {
            return;
        }

        $entitiesHtml = "";
        foreach($entities as $entity) {
            $id = $entity->getId();
            $thumbnail = $entity->getThumbnail();
            $name = $entity->getName();
            $entitiesHtml .= "<a href='entity.php?id=$id'>
                                <div class='previewContainer small'>
                                    <img src='$thumbnail' title='$name'>
                                </div>
                            </a>";
        }

        return "<div class='category'>
                    <div class='entities'>
                        $entitiesHtml
                    </div>
                </div>";
    }
}
?>