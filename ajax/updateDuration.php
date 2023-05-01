<?php
require_once("../includes/config.php");

if (isset($_POST["videoId"]) && isset($_POST["username"]) && isset($_POST["progress"])) {
    $query = $con->prepare("Update videoprogress set progress=:progress,
                            dateModified=NOW() where videoId=:videoId and username=:username");
    $query->bindValue(":progress", $_POST["progress"]);
    $query->bindValue(":videoId", $_POST["videoId"]);
    $query->bindValue(":username", $_POST["username"]);
    $query->execute();

   
} else {
    echo "No videoId or username passed";
}

?>