<?php
    session_start(); //to ensure you are using same session
    session_destroy(); //destroy the session
    header('Location: index.php');
    exit();
?>

<h3>Vous avez été déconnecté. <a href="index.php">Retour à l'accueil</a></h3>

