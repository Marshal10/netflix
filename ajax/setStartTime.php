<?php
require_once("../includes/config.php");

if (isset($_POST["videoId"]) && isset($_POST["username"])) {
    $query = $con->prepare("Select progress from videoprogress
                            where videoId=:videoId and username=:username");
    $query->bindValue(":videoId", $_POST["videoId"]);
    $query->bindValue(":username", $_POST["username"]);
    $query->execute();

    echo $query->fetchColumn();

   
} else {
    echo "No videoId or username passed";
}

?>