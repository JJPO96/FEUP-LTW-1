<?php
    include_once('../database/connection.php');
    include_once('../database/reply.php');

    insertReply($db, $_POST['idReview'], $_POST['idUser'], $_POST['content']);

    $location = "../pages/restaurant.php?id=" . $_POST['idRestaurant'];
    header("Location: " . $location);
?>