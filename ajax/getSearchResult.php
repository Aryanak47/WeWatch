<?php
require_once("../includes/config.php");
require_once("../includes/classes/FormSanitizer.php");
require_once("../includes/classes/EntityProvider.php");
require_once("../includes/classes/Entity.php");

if(isset($_POST["text"]) && isset($_POST["username"])) {
    $text = FormSanitizer::getSafeValue($_POST['text']);
    $entities = EntityProvider::getSearchEntities($conn, $text);
    if(count($entities) > 0){
        echo getResults($entities);
        return;
    }
    // call api 
    echo 0;
    

}
else {
    echo "No term or username passed into file";
}



 function getResults($entities) {
    $html = "<div class='previewCategories noScroll'>";
    if(count($entities) < 1){
        $html .= "<h2> No results found</h2></div>";
        return $html;

    }

    $html = "<div class='previewCategories noScroll'>";

    $html .= getResultHtml($entities);

    return $html . "</div>";
}

 function getResultHtml($entities) {
  

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
?>