<?php
require_once("includes/header.php");

$preview=new PreviewProvider($con,$userLoggedIn);
$preview->createPreviewVideo(null);

$category=new CategoryContainer($con,$userLoggedIn);
$category->getCategories();
?>
