<?php
require_once("includes/header.php");

if(!isset($_GET["id"])){
    ErrorMessage::show("No id is passed");
}
$entityId=$_GET["id"];
$entity=new Entity($con,$entityId);

$preview=new PreviewProvider($con,$userLoggedIn);
$preview->createPreviewVideo($entity);

$season=new SeasonProvider($con,$userLoggedIn);
$season->create($entity);

$showCategory=new CategoryContainer($con,$userLoggedIn);
$showCategory->showCategories($entity->getCategoryId(),"You Might Also Like");
?>
