<?php
    session_start();
    
    
    include "include/head.php";
	
	$db->exec('Update utilisateur set nomUser=upper("'.$_SESSION['nom'].'") where emailUser="'.$_SESSION['email'].'"');
	$db->exec('Update utilisateur set prenomUser=initCap("'.$_SESSION['prenom'].'") where emailUser="'.$_SESSION['email'].'"');
	$laBd=$db->query('select nomUser,prenomUser from utilisateur where emailUser="'.$_SESSION['email'].'";');
    while($data=$laBd->fetch())
	{
		$_SESSION['nom']=$data['nomUser'];
		$_SESSION['prenom']=$data['prenomUser'];
	}
	
	header('Location: compte.php');
    exit();