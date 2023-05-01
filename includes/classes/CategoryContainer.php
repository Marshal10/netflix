<?php

class CategoryContainer
{

    private $con;
    private $username;
    public function __construct($con, $username)
    {
        $this->con = $con;
        $this->username = $username;

    }


    public function getCategories()
    {
        $query = $this->con->prepare("Select * from categories");
        $query->execute();
        $html = "<div class='categoryContainer'>";

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $html .= $this->getCategoryHtml($row, null, true, true);
        }

        echo $html . "</div>";
    }

    public function getTVShowCategories()
    {
        $query = $this->con->prepare("Select * from categories");
        $query->execute();
        $html = "<div class='categoryContainer'>
                    <h1>TV Shows</h1>";

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $html .= $this->getCategoryHtml($row, null, true, false);
        }

        echo $html . "</div>";
    }

    public function getMovieCategories()
    {
        $query = $this->con->prepare("Select * from categories");
        $query->execute();
        $html = "<div class='categoryContainer'>
                    <h1>Movies</h1>";

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $html .= $this->getCategoryHtml($row, null, false, true);
        }

        echo $html . "</div>";
    }

   

    public function showCategories($categoryId, $title = null)
    {
        $query = $this->con->prepare("Select * from categories where id=:id");
        $query->bindValue(":id", $categoryId);
        $query->execute();
        $html = "<div class='categoryContainer noScroll'>";

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $html .= $this->getCategoryHtml($row, $title, true, true);
        }

        echo $html . "</div>";
    }

    private function getCategoryHtml($sqlData, $title, $tvShows, $movies)
    {
        $categoryId = $sqlData["id"];
        $title = $title == null ? $sqlData["name"] : $title;

        if ($tvShows && $movies) {
            $entities = EntityProvider::getEntity($this->con, $categoryId, 30);
        } else if ($tvShows) {
            $entities = EntityProvider::getTVShowEntity($this->con, $categoryId, 30);
        } else {
            $entities = EntityProvider::getMovieEntity($this->con, $categoryId, 30);
        }

        if (sizeof($entities) == 0) {
            return;
        }

        $entitiesHtml = "";
        $previewProvider = new PreviewProvider($this->con, $this->username);
        foreach ($entities as $entity) {
            $entitiesHtml .= $previewProvider->createEntityPreviewSquare($entity);
        }

        return "<div class='category'>
                    <h3><a href='category.php?id=$categoryId'>
                        $title
                    </a></h3>
                    <div class='entities'>
                        $entitiesHtml
                    </div>
                </div>";
    }
}

?>