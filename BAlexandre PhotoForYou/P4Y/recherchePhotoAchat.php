<?php
	
	session_start();
	
	//Pour la connexion à la base de données
	include "include/head.php";
	
	header('Location: achatImages.php?categorie='.$_POST['findCateg']);
	exit();