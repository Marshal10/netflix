<?php
require_once("includes/header.php");

if(!isset($_GET["id"])){
    ErrorMessage::show("No id is passed");
}

$preview=new PreviewProvider($con,$userLoggedIn);
$preview->createCategoryPreviewVideo($_GET["id"]);

$category=new CategoryContainer($con,$userLoggedIn);
$category->showCategories($_GET["id"]);
?>
