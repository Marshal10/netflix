<?php
class EntityProvider{

    public static function getEntity($con,$categoryId,$limit){
        $sql="Select * from entities ";

        if($categoryId!=null){
            $sql .="where categoryId=:categoryId ";
        }

        $sql.="ORDER BY RAND() LIMIT :limit";

        $query=$con->prepare($sql);

        IF($categoryId!=null){
            $query->bindValue(":categoryId",$categoryId);
        }
        
        $query->bindValue(":limit",$limit,PDO::PARAM_INT);
        $query->execute();

        $result=array();

        while($row=$query->fetch(PDO::FETCH_ASSOC)){
            $result[]=new Entity($con,$row);
        }
        
        return $result;
    }

    public static function getTVShowEntity($con,$categoryId,$limit){
        $sql="Select DISTINCT(entities.id) from entities
              inner join videos
              on entities.id=videos.entityId
              where videos.isMovie=0 ";

        if($categoryId!=null){
            $sql .="and categoryId=:categoryId ";
        }

        $sql.="ORDER BY RAND() LIMIT :limit";

        $query=$con->prepare($sql);

        IF($categoryId!=null){
            $query->bindValue(":categoryId",$categoryId);
        }
        
        $query->bindValue(":limit",$limit,PDO::PARAM_INT);
        $query->execute();

        $result=array();

        while($row=$query->fetch(PDO::FETCH_ASSOC)){
            $result[]=new Entity($con,$row["id"]);
        }
        
        return $result;
    }

    public static function getMovieEntity($con,$categoryId,$limit){
        $sql="Select DISTINCT(entities.id) from entities
              inner join videos
              on entities.id=videos.entityId
              where videos.isMovie=1 ";

        if($categoryId!=null){
            $sql .="and categoryId=:categoryId ";
        }

        $sql.="ORDER BY RAND() LIMIT :limit";

        $query=$con->prepare($sql);

        IF($categoryId!=null){
            $query->bindValue(":categoryId",$categoryId);
        }
        
        $query->bindValue(":limit",$limit,PDO::PARAM_INT);
        $query->execute();

        $result=array();

        while($row=$query->fetch(PDO::FETCH_ASSOC)){
            $result[]=new Entity($con,$row["id"]);
        }
        
        return $result;
    }

    public static function getSearchEntities($con,$term){
        $sql="Select * from entities where name like concat('%',:term,'%') limit 30";

        $query=$con->prepare($sql);

        $query->bindValue(":term",$term);
        $query->execute();

        $result=array();

        while($row=$query->fetch(PDO::FETCH_ASSOC)){
            $result[]=new Entity($con,$row);
        }
        
        return $result;
    }
}
?>