<?php
require_once("includes/config.php");
require_once("includes/classes/PreviewProvider.php");
require_once("includes/classes/Entity.php");
require_once("includes/classes/CategoryContainer.php");
require_once("includes/classes/EntityProvider.php");
require_once("includes/classes/ErrorMessage.php");
require_once("includes/classes/SeasonProvider.php");
require_once("includes/classes/Video.php");
require_once("includes/classes/Season.php");
require_once("includes/classes/VideoProvider.php");
require_once("includes/classes/User.php");

if (!isset($_SESSION["userLoggedIn"])) {
    header("location:register.php");
}

$userLoggedIn = $_SESSION["userLoggedIn"];
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/style.css">
    </link>
    <link rel="icon" type="image/x-icon" href="./assets/styles/imgs/favicon.ico"></link>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="assets/js/script.js"></script>
    <script src="https://kit.fontawesome.com/7d40258f74.js" crossorigin="anonymous"></script>

    <title>Marflix</title>
</head>

<body>
    <div class="wrapper">
        <?php
        if (!isset($hideNav)) {
            include_once("includes/navBar.php");
        }
        ?>