<?php
    session_start();
    $_SESSION['idPage']=0;
	//la personne ne s'est pas encore connectée
     if(!isset($_SESSION['total']) && !isset($_SESSION['nbPanier']) && !isset($_SESSION['user']) && !isset($_SESSION['email']) && !isset($_SESSION['panier']) && !isset($_SESSION['type']) && !isset($_SESSION['credit']) && !isset($_SESSION['nom']) && !isset($_SESSION['prenom']))
    {
        $_SESSION['user']=null;
        $_SESSION['email']=null;
		$_SESSION['type']=null;
		$_SESSION['credit']=null;
		$_SESSION['nom']=null;
		$_SESSION['prenom']=null;
		$_SESSION['panier']=null;
		$_SESSION['nbPanier']=0;
		$_SESSION['total']=0;
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include "include/head.php";?>
<body>
<div id="container">
    <?php include "include/leMenu.php";?>
    <div id="body">
		<?php
			
			
		
			if($_SESSION['user']==null)
			{
				include "include/coteDroit.php";
			}
			
			$laBd=$db->query('select * from utilisateur,image,acheter where pseudo=photographePseudo and emailAcheteur="'.$_SESSION['email'].'" and idImg=idImageAchete;');
			while($data=$laBd->fetch())
			{
				if($_GET['idImage']==$data['idImg'])
				{
					$leLien=$data['lienImg'];
					$lePseudo=$data['pseudo'];
					$lePrix=$data['prix'];
					$titre=$data['nomImage'];
				}
				
			}
			if(!isset($leLien) && !isset($lePseudo) && !isset($lePrix) && !isset($titre))
			{
				$laBd=$db->query('select * from image');
				while($data=$laBd->fetch())
				{
					if($_GET['idImage']==$data['idImg'])
					{
						$leLien="uploads/".$_GET['idImage']."_Protec.jpeg";
						$lePseudo=$data['photographePseudo'];
						$lePrix=$data['prix'];
						$titre=$data['nomImage'];
					}
				}
			}
			
		?>
		<h2>Nom de l'image: <?= $titre ?></h2>
		<img src="<?= $leLien ?>" height="50%" width="50%">
		<p>Pseudonyme du photographe: <?= $lePseudo ?></p>
		<p>Prix: <?= $lePrix ?></p>
		<?php 
			if($_SESSION['type']=="client")
			{
				echo '<form action="ajoutPanier.php?idImage='.$_GET['idImage'].'" method="POST">
					<input type="submit">
				</form>';
			}
			elseif($_SESSION['type']=="photographe" and $_SESSION['user']==$lePseudo)
			{
				$laBd=$db->query('select nbAcheteur('.$_GET['idImage'].') as nb;');
				while($data=$laBd->fetch())
				{
					$tot=$data['nb'];
				}
				
				echo 	"Nombre d'acheteurs: ".$tot;
				
				echo	'<form action="modImage.php?idImage='.$_GET['idImage'].'" method="POST">
							<label>Nouveau Prix</label><input type="number" name="newprix" step=0.01><br/>
							<label>Nouveau Titre</label><input type="text" name="newNom">
							<input type="submit" value="MODIFIER">
						</form>';
						
							
				
				echo	'<form action="delPhoto.php?idImage='.$_GET['idImage'].'" method="POST">
							<input type="submit" value="RETIRER DU CATALOGUE">
						</form>';
			}
		?>
			
    	<div class="clear"></div>
    </div>
    <?php include "include/footer.html";?> 
</div>
</body>
</html>
