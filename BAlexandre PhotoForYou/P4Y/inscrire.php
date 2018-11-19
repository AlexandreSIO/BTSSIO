<?php

	//Pour la connexion à la base de données//
	include "include/head.php";
	
	$no=false;
	$location="";
	
	//On verifie qu'il n'y ai pas de doublon de pseudo, d'oublie des noms, de mot de passe valide et que les contraintes lié au compte soient respectées// 
	$laBd=$db->query("select * from utilisateur");
    while($data=$laBd->fetch())
	{	
		if($_POST['mailReg']==$data['emailUser'] and $_POST['typeReg']==$data['typeUser'])
		{
			if($no==false)
			{
				$location=$location."dejaPrit=true";
				$no=true;
			}
			else
			{
				$location=$location."&dejaPrit=true";
			}
		}
		
		if($_POST['pseudoReg']==$data['pseudo'])
		{
			if($no==false)
			{
				$location=$location."dejaPritPseudo=true";
				$no=true;
			}
			else
			{
				$location=$location."&dejaPritPseudo=true";
			}
		}
		
		if(!preg_match('#(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])#', $_POST['pswReg']))
		{
			if($no==false)
			{
				$location=$location."badPsw=true";
				$no=true;
			}
			else
			{
				$location=$location."&badPsw=true";
			}
		}
		
		if($_POST['mailReg']==null)
		{
			if($no==false)
			{
				$location=$location."mailEmpty=true";
				$no=true;
			}
			else
			{
				$location=$location."&mailEmpty=true";
			}
		}
		
		if($_POST['nomReg']==null)
		{
			if($no==false)
			{
				$location=$location."nameEmpty=true";
				$no=true;
			}
			else
			{
				$location=$location."&nameEmpty=true";
			}
		}
		
		if($_POST['prenomReg']==null)
		{
			if($no==false)
			{
				$location=$location."pnameEmpty=true";
				$no=true;
			}
			else
			{
				$location=$location."&pnameEmpty=true";
			}
		}
		
		if($_POST['pseudoReg']==null)
		{
			if($no==false)
			{
				$location=$location."pseudoEmpty=true";
				$no=true;
			}
			else
			{
				$location=$location."&pseudoEmpty=true";
			}
		}
	}
	
	
	if($no==true)
	{
		header('Location: inscription.php?'.$location);
		exit();
	}
	
	//il n'y aucun problemes. Le compte peut être créé//
	if(isset($_POST['mailReg']) and isset($_POST['nomReg'])and isset($_POST['prenomReg']) 
	and isset($_POST['pswReg']) and strlen($_POST['pswReg'])>5 and strlen($_POST['pswReg'])<21 
	and preg_match('#(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])#', $_POST['pswReg']))
	{
		$elMail=$_POST['mailReg'];
		$elNom=$_POST['nomReg'];
		$elPrenom=$_POST['prenomReg'];
		$elType=$_POST['typeReg'];
		$elPseudo=$_POST['pseudoReg'];
		$elMDP=sha1($_POST['pswReg']);
		
		$laReqInsert='insert into utilisateur values ("'.$elMail.'","'.$elType.'","'.$elPseudo.'","'.$elMDP.'",upper("'.$elNom.'"),initCap("'.$elPrenom.'"),0);';
		$db->exec($laReqInsert);
	
		//envoie vers la page d'accueil et ferme la page//
		header('Location: accueil.php');
		exit();
	}
	else
	{
		header('Location: inscription.php');
		exit();
	}