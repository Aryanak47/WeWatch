<?php
require_once("../includes/config.php");
require_once("../includes/classes/FormSanitizer.php");
require_once("../includes/classes/SearchResultsProvider.php");
require_once("../includes/classes/EntityProvider.php");
require_once("../includes/classes/Entity.php");

if(isset($_POST["text"]) && isset($_POST["username"])) {
    $text = FormSanitizer::getSafeValue($_POST['text']);
    $srp = new SearchResultsProvider($conn, $_POST["username"]);
    echo $srp->getResults($text);

}
else {
    echo "No term or username passed into file";
}
?>