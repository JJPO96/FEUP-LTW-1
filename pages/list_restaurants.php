<?php
    require_once('../database/connection.php');
    require_once ('../database/restaurant.php');

    try {
        $restaurants = getAllRestaurants($db);
    }
    catch(PDOException $e) {
        die($e->getMessage());
    }

    $cssStyle = "../styles/listrestaurantstyle.css";

    require('../templates/header.php');
    require('../templates/list_restaurants.php');
    require('../templates/footer.php');
?>