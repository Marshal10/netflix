<?php

class VideoProvider
{
    public static function getUpNext($con, $currentVideo)
    {
        $query = $con->prepare("Select * from videos where 
                              entityId=:entityId and id!=:videoId and
                              (
                                (season=:season and episode>:episode) or season>:season
                              ) order by season,episode asc limit 1");
        $query->bindValue(":entityId", $currentVideo->getEntityId());
        $query->bindValue(":videoId", $currentVideo->getId());
        $query->bindValue(":season", $currentVideo->getSeasonNumber());
        $query->bindValue(":episode", $currentVideo->getEpisodeNumber());

        $query->execute();

        if ($query->rowCount() == 0) {
            $query = $con->prepare("Select * from videos where 
                                  season<=1 and episode<=1
                                  and id!=:videoId
                                  order by views desc limit 1");

            $query->bindValue(":videoId", $currentVideo->getId());
            $query->execute();
        }

        $row = $query->fetch(PDO::FETCH_ASSOC);
        return new Video($con, $row);
    }

    public static function getEntityVideoForUser($con, $entityId, $username)
    {
        $query = $con->prepare("Select videoId from videoprogress
                                inner join videos
                                on videoprogress.videoId=videos.id
                                where videos.entityId=:entityId
                                and videoprogress.username=:username
                                order BY videoprogress.dateModified DESC limit 1;");

        $query->bindValue(":entityId", $entityId);
        $query->bindValue(":username", $username);

        $query->execute();

        if ($query->rowCount() == 0) {
            $query = $con->prepare("Select id from videos
                                   where entityId=:entityId
                                   order by season,episode ASC limit 1");

            $query->bindValue(":entityId", $entityId);
            $query->execute();
        }

        return $query->fetchColumn();

    }
}

?>

<!-- Select videoId from videoprogress
                                 Inner Join videos  
                                 on videoprogress.videoId=videos.id 
                                 where videos.entityId=:entityId and videoprogress.username=:username
                                 order BY videoprogress.dateModified DESC limit 1; -->