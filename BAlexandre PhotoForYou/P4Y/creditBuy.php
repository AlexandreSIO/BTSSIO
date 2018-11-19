<?php
	
	session_start();
	
	//Pour la connexion à la base de données
	include "include/head.php";
	
	if(isset($_POST['newCredit']) and $_POST['newCredit']>0 and isset($_SESSION['user']))
	{
		$neoCredit=$_POST['newCredit'];
		
		$laReqInsert='update utilisateur set credit=credit+'.$neoCredit.' where pseudo="'.$_SESSION['user'].'";';
		$db->exec($laReqInsert);
		$laBD=$db->query('select credit from utilisateur where pseudo="'.$_SESSION['user'].'" and emailUser="'.$_SESSION['email'].'";');
		$data=$laBD->fetch();
		$_SESSION['credit']=$data['credit'];
		$laBD->closeCursor();
	
		//envoie vers la page d'accueil et ferme la page
		header('Location: accueil.php');
		exit();
	}
	else
	{
		header('Location: achatCredit.php');
		exit();
	}