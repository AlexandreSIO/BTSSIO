<?php
    session_start();
    
    
    include "include/head.php";
	
	$db->exec('Update utilisateur set credit=0 where emailUser="'.$_SESSION['email'].'"');
	$_SESSION['credit']=0;
	
	header('Location: compte.php');
    exit();