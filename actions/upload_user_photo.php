<?php
    session_start();

    include_once("../database/connection.php");
    include_once("../database/user.php");

    if (isset($_POST["uploaduserphoto"])){

        if ($_FILES['userphoto']['error'] !== UPLOAD_ERR_OK) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            die("Upload failed with error code " . $_FILES['userphoto']['error']);
        }

        $info = getimagesize($_FILES['userphoto']['tmp_name']);
        if ($info === FALSE) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            die("Unable to determine image type of uploaded file");
        }

        if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            die("Not a gif/jpeg/png");
        }

        if ($_FILES["userphoto"]["size"] > 1048576) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            echo "File should not be bigger than 1 MB. ";
        }

        $targetDir = "../uploads/users/"; // Directory to save the file
        $targetName = basename($_FILES["userphoto"]["name"]);  // Name of the file
        $fileType = pathinfo($targetName ,PATHINFO_EXTENSION); // File type
        $fileName = $_SESSION['username'] . '.' . $fileType;
        $targetFile = $targetDir . $fileName; // Final path to save the file

        if(file_exists($fileName)) {
            chmod($fileName); //Change the file permissions if allowed
            unlink($fileName); //remove the file
        }

        if (move_uploaded_file($_FILES['userphoto']['tmp_name'], $targetFile)) {
            updateUserPhoto($db, $_SESSION['username'], $_SESSION['username']);

            echo 'File saved.';
        } else {
            echo 'File failed to save\n';
        }
    }

    header('Location: ' . '../pages/profile.php');
?>