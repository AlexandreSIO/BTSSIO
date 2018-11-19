<?php
session_start();
if(isset($_SESSION['user']))
{
    session_destroy();
}
//Renvoie a la page d'accueil//
header('Location: accueil.php');
exit();