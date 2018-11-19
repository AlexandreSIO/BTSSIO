<?php

	session_start();
	
	include "include/head.php";

	//Pour la connexion à la base de données//
	include "include/head.php";
	
	$i=0;
	
	if($_SESSION['credit']>=$_SESSION['total'] and $_SESSION['nbPanier']>0)
	{
		foreach($_SESSION['panier'] as $item)
		{
			$db->exec('insert into acheter values ('.$item.',"'.$_SESSION['email'].'");');
			$db->exec('call payerPhotographe("'.$_SESSION['user'].'",'.$item.');');
			unset($_SESSION['panier'][$i]);
			$i++;
		}
		$_SESSION['total']=0;
		$_SESSION['nbPanier']=0;
	}
	
	header('Location: compte.php');
	exit();