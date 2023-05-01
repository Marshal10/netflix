<?php
require_once("includes/header.php");

$preview=new PreviewProvider($con,$userLoggedIn);
$preview->createMoviePreviewVideo();

$category=new CategoryContainer($con,$userLoggedIn);
$category->getMovieCategories();
?>
