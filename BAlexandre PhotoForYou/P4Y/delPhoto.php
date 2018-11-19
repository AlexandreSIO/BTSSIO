<?php
    session_start();
    
    
    include "include/head.php";
	
	
	$laBd=$db->query('select * from image ;');
	if($_SESSION['type']=="photographe")
	{
		while($data=$laBd->fetch())
		{
			if($data['photographePseudo']==$_SESSION['user'])
			{
				$db->exec('delete from image where idImg='.$_GET['idImage']);
				$db->exec('delete from classer where idImage='.$_GET['idImage']);
				$db->exec('delete from acheter where idImageAchete='.$_GET['idImage']);
		}
	}
	
	header('Location: achatImages.php');
    exit();