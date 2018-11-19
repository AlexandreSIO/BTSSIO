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
				$db->exec('update image set nomImage="'.$_POST['newNom'].'" where idImg="'.$_GET['idImage'].'"');
				$db->exec('update image set prix='.$_POST['newprix'].' where idImg="'.$_GET['idImage'].'"');
			}
		}
	}
	
	header('Location: achatImages.php');
    exit();