<?php

class PreviewProvider
{

    private $con;
    private $username;
    public function __construct($con, $userName)
    {
        $this->con = $con;
        $this->username = $userName;

    }

    public function createTVShowPreviewVideo(){
        $entitiesArray=EntityProvider::getTVShowEntity($this->con,null,1);

        if(sizeof($entitiesArray)==0){
            ErrorMessage::show("No Tv Shows to display");
        }

        return $this->createPreviewVideo($entitiesArray[0]);

    }

    public function createCategoryPreviewVideo($categoryId){
        $entitiesArray=EntityProvider::getTVShowEntity($this->con,$categoryId,1);

        if(sizeof($entitiesArray)==0){
            ErrorMessage::show("No Categories to display");
        }

        return $this->createPreviewVideo($entitiesArray[0]);

    }
    public function createMoviePreviewVideo(){
        $entitiesArray=EntityProvider::getMovieEntity($this->con,null,1);

        if(sizeof($entitiesArray)==0){
            ErrorMessage::show("No Movies to display");
        }

        return $this->createPreviewVideo($entitiesArray[0]);
    }

    public function createPreviewVideo($entity)
    {
        if ($entity == null) {
            $entity = $this->getRandomEntity();
        }

        $id = $entity->getId();
        $name = $entity->getName();
        $thumbnail = $entity->getThumbnail();
        $preview = $entity->getPreview();

        $videoId=VideoProvider::getEntityVideoForUser($this->con,$id,$this->username);
        $video=new Video($this->con,$videoId);
        $seasonEpisode=$video->getSeasonAndEpisode();
        $subHeading=$video->isMovie()?"":"<h4>$seasonEpisode</h4>";
        $isProgress=$video->isInProgress($this->username);
        $playButtonText=$isProgress?"Continue Watching":"Play";

        echo "<div class='previewContainer'>
                    <img src='$thumbnail' class='previewImage' hidden>

                    <video autoplay muted class='previewVideo' onended='previewEnded()'>
                        <source src='$preview' >
                    </video>
                    <div class='previewOverlay'>
                        <div class='mainDetails'>
                            <h1>$name</h1>
                            $subHeading
                            <div class='buttons'>
                                <button onclick='watchVideo($videoId)'><i class='fas fa-play'></i> $playButtonText</button>
                                <button onClick='volumeToggle(this)'><i class='fas fa-volume-mute'></i></button>
                            </div>
                        </div>
                    </div>
                </div>";

    }

    public function createEntityPreviewSquare($entity){
        $id=$entity->getId();
        $thumbnail=$entity->getThumbnail();
        $name=$entity->getName();

        return "<a href='entity.php?id=$id'>
                    <div class='previewContainer small'>
                        <img src='$thumbnail' title='$name'>
                    </div>
                </a>";
    }

    public function getRandomEntity()
    {
        $entity=EntityProvider::getEntity($this->con,null,1);
        return $entity[0];
    }
}
?>