<?php
	
	session_start();
	
	//Pour la connexion à la base de données
	include "include/head.php";
	
	$yes=true;
	//Verifie si la photo a deja achetée par le l'utilisateur
	$laBd=$db->query('select * from acheter where emailAcheteur="'.$_SESSION['email'].'";');
    while($data=$laBd->fetch())
	{
		if($data['idImageAchete']==$_GET['idImage'])
		{
			$yes=false;
		}
	}
	
	//Verifie que l'image ne soit pas deux fois dans le panier
	foreach($_SESSION['panier'] as $item)
	{
		if($item==$_GET['idImage'])
		{
			$yes=false;
		}
	}
		
	//Les conditions sont remplies, l'image peut être ajouté au panier
	if($yes==true)
	{
		$_SESSION['panier'][]=$_GET['idImage'];
		$_SESSION['nbPanier']++;
		$laBd=$db->query('select prix from image where idImg="'.$_GET['idImage'].'";');
		while($data=$laBd->fetch())
		{
			$_SESSION['total']=$_SESSION['total']+$data['prix'];
		}
	}
	
	//Renvoie vers la page de l'image
	header('Location: voirUneImage.php?idImage='.$_GET['idImage']);
	exit();
	