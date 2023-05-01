<?php
require_once("../includes/config.php");

if (isset($_POST["videoId"]) && isset($_POST["username"])) {
    $query = $con->prepare("Update videoprogress set finished=1, progress=0
                            where videoId=:videoId and username=:username");
    $query->bindValue(":videoId", $_POST["videoId"]);
    $query->bindValue(":username", $_POST["username"]);
    $query->execute();

   
} else {
    echo "No videoId or username passed";
}

?>