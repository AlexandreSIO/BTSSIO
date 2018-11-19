<?php
	
	session_start();
	
	//Pour la connexion à la base de données
	include "include/head.php";
	
	$prob="";
	$directory = "uploads/";
	$lien = $directory . basename($_FILES["imageVendre"]["name"]);
	$yes = true;
	$extImage = strtolower(pathinfo($lien,PATHINFO_EXTENSION));
	$laReqInsert='insert into image(lienImg,prix,photographePseudo,nomImage) values ("'.$lien.'",'.$_POST['prixVendre'].',"'.$_SESSION['user'].'","'.$_POST['nomVendre'].'");';
	
	// Verifie si c'est une image
	$valide = getimagesize($_FILES["imageVendre"]["tmp_name"]);
	if($valide !== false)
	{
		$yes = true;
	} 
	else
	{
		$yes = false;
		$prob=$prob.'PasUneImage=true&';
	}
	
	// Verifie si le fichier existe deja dans le dossier
	if (file_exists($lien))
	{
		$yes = false;
		$prob=$prob.'EXISTS=true&';
		
	}
	// Verifie le poid de l'image
	if ($_FILES["imageVendre"]["size"] > 31457280)
	{
		$yes = false;
		$prob=$prob.'poid=true&';
	}
	// Verifie que l'image soit en .jpeg
	if($extImage == "jpg" or $extImage == "jpeg")
	{
		
	}
	else
	{
		$prob=$prob.'formatProb=true&format='.$extImage.'&';
	}
	
	//Verifie que le prix de l'image soit entr 2 et 100 crédits
	if($_POST['prixVendre']>100 or $_POST['prixVendre']<2)
	{
		$prob=$prob.'prix='.$_POST['prixVendre'].'&prixProb=true&';
	}
	//Verifie que l'image soit égale ou supérieure à 2400x1600
	list($width, $height) = getimagesize($_FILES["imageVendre"]["tmp_name"]);
	if($width<2399 and $height<1499)
	{
		
	}
	else
	{
		$prob=$prob.'height='.$height.'&width='.$width.'&hwProb=true&';
	}	
	// verifie les erreurs
	if ($yes == false)
	{
		header('Location: compte.php?'.$prob);
		exit();
	// Si toutes ces conditions sont respectées, l'upload se fait
	}
	else
	{
		if (move_uploaded_file($_FILES["imageVendre"]["tmp_name"], $lien))
		{
			$db->exec($laReqInsert);
			$laBd=$db->query('select * from image where lienImg="'.$lien.'";');
			while($data=$laBd->fetch())
			{
				
			// Charge l'image sur laquelle le filigrane doit etre appliqué
			$image = imagecreatefromjpeg($data['lienImg']);
			//Resolution de l'image aidant au calcul de la position du filigrane
			list($width, $height) = getimagesize($data['lienImg']);

			//Definition de la taille du filigrane
			$filigrane = imagecreatetruecolor($width*0.3, $height*0.2);
			//Hauteur et largeur du filigrane réutilisable pour le cadre orange du filigrane
			$fWidth=$width*0.3;
			$fheight=$height*0.2;
			//Rectangles dessinés a l'interieur du filigrane
			imagefilledrectangle($filigrane, 0, 0, $fWidth, $fheight, 0xFF6633);
			imagefilledrectangle($filigrane, $fWidth*0.05, $fheight*0.05, $fWidth*0.95, $fheight*0.95, 0xFFFFFF);
			//Texte du Filigrane
			imagestring($filigrane, 5, 20, 20, 'Photo For You', 0x000000);
			imagestring($filigrane, 3, 20, 40, $_SESSION['user'], 0x000000);

			// Place du filigrane sur l'image
			$marge_right = $width*0.5;
			$marge_bottom = $height*0.2;
			$filigraneX = imagesx($filigrane);
			$filigraneY = imagesy($filigrane);

			// On insert le filigrane dans la photo
			imagecopymerge($image, $filigrane, imagesx($image) - $filigraneX - $marge_right, imagesy($image) - $filigraneY - $marge_bottom, 0, 0, imagesx($filigrane), imagesy($filigrane), 60);

			// Sauvegarde l'image dans un fichier et libère la mémoire
			imagejpeg($image, 'uploads/'.$data['idImg'].'_Protec.jpeg');
			$leLienProtec='uploads/'.$data['idImg'].'_Protec.jpeg';
			$laReqUpDate='update image set lienImgProtec="'.$leLienProtec.'" where idImg="'.$data['idImg'].'";';
			$db->exec($laReqUpDate);
			imagedestroy($image);
			
			//On rentre une categorie pour l'image
			$reqExec='insert into classer values('.$data['idImg'].','.$_POST['catVendre'].');';
			$db->exec($reqExec);
			
			}
			//envoie vers la page d'accueil et ferme la page
			header('Location: compte.php');
			exit();
		}
		//Indique si elle ne peut pas être uploadé pour des raisons autres
		else
		{
			header('Location: compte.php?PasUpload');
			exit();
		}
	}