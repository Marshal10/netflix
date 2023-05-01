<?php
require_once("includes/header.php");

$preview=new PreviewProvider($con,$userLoggedIn);
$preview->createTVShowPreviewVideo();

$category=new CategoryContainer($con,$userLoggedIn);
$category->getTVShowCategories();
?>