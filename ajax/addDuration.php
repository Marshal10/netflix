<?php
require_once("../includes/config.php");

if (isset($_POST["videoId"]) && isset($_POST["username"])) {
    $query = $con->prepare("Select * from videoprogress where videoId=:id and username=:username");
    $query->bindValue(":id", $_POST["videoId"]);
    $query->bindValue(":username", $_POST["username"]);
    $query->execute();

    if ($query->rowCount() == 0) {
        $query = $con->prepare("Insert into videoprogress(videoId,username)Values(:videoId,:username)");
        $query->bindValue(":videoId", $_POST["videoId"]);
        $query->bindValue(":username", $_POST["username"]);

        $query->execute();

    }
} else {
    echo "No videoId or username passed";
}

?>