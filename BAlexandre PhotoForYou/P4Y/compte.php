<?php
    session_start();
    $_SESSION['idPage']=7;
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
	
		<h2>Porte-monnaie</h2>
		<p>Crédit(s) sur le compte: <?= $_SESSION['credit']?></p><br/>
		<?php 
			if($_SESSION['type']=="photographe")
			{
				echo 
				'<form action="retirerCredit.php" method="POST">
					<input type="submit" value="Retirer Crédits">
				</form>';
			}
		?>
		<h2>Informations personnelles</h2>
		<p>Nom: <?= $_SESSION['nom']?></p>
		<p>Prénom: <?= $_SESSION['prenom']?></p>
		<p>E-mail: <?= $_SESSION['email']?></p>
		<form action="compteChangerNomPrenom.php" method="POST">
			<label>Nouveau Nom: </label><input type="text" name="neoNom"><br/>
			<label>Nouveau Prénom: </label><input type="text" name="neoPrenom"><br/>
			<input type="submit" value="Changer">
		</form>
		
		<?php
			if($_SESSION['type']=="client")
			{
				echo "<h2>Photographies achetées</h2>";
				$br=1;
				$laBd=$db->query('select * from image,acheter where emailAcheteur="'.$_SESSION['email'].'" and idImg=idImageAchete;');
				while($data=$laBd->fetch())
				{
					if($br<4)
					{
						echo '<a href="voirUneImage.php?idImage='.$data['idImg'].'"><img src="'.$data['lienImg'].'" height="25%" width="25%"></a>';
						$br++;
					}
					else
					{
						echo '<a href="voirUneImage.php?idImage='.$data['idImg'].'"><img src="'.$data['lienImg'].'" height="25%" width="25%"></a></br>';
						$br=1;
					}
					
				}
			}
			elseif($_SESSION['type']=="photographe")
			{
				echo "<h2>Mettre en vente une photographie</h2>";
				echo 	'<form action="vendrePhoto.php" method="post" enctype="multipart/form-data">
							<label>Nom: </label></br><input type="text" name="nomVendre"><p>Son nom dans le catalogue</p><br/>
							<label>Photographie: </label></br><input type="file" name="imageVendre" accept=".jpg, .jpeg"><p>Doit être en .jpeg ou .jpg, faire moins de 30mo et avoir une resolution de minimum 2400x1600 pixels</p>';
							if(isset($_GET['hwProb']) and $_GET['hwProb']==true)
							{
								echo '<p>Votre image ne correspond pas à la resolution minimum attendue de 2400x1600. Votre image fait '.$_GET['width'].'x'.$_GET['height'].'</p>';
							}
							if(isset($_GET['formatProb']) and $_GET['formatProb']==true)
							{
								echo "<p>Votre image n'est pas au bon format, votre fichier est en ".$_GET['format']." alors qu'il devrait être en jpeg/jpg</p>";
							}
							if(isset($_GET['EXISTS']) and $_GET['EXISTS']==true)
							{
								echo "<p>Une image possede le même nom de fichier dans notre repertoire</p>";
							}
							if(isset($_GET['poid']) and $_GET['poid']==true)
							{
								echo "<p>Votre photographie dépasse 30Mo</p>";
							}
							if(isset($_GET['PasUneImage']) and $_GET['PasUneImage']==true)
							{
								echo "<p>Ce fichier n'est pas une image</p>";
							}
							echo '<label>Categorie: </label>
									<select name="catVendre">';
										$laBdCat=$db->query('select * from categorie;');
										while($dataCat=$laBdCat->fetch())
										{
											echo '<option value="'.$dataCat['nomCat'].'">'.$dataCat['nomCat'].'</option>';
										}
							echo	'</select></br>';
				echo '</br>
							<label>Prix: </label></br><input type="number" name="prixVendre" step=0.01><p>Entre 2 et 100 credits</p>';
							if(isset($_GET['prixProb']) and $_GET['prixProb']==true)
							{
								if(!isset($_GET['prix']) or $_GET['prix']==null)
								{
									$textPrix=0;
								}
								else
								{
									$textPrix=$_GET['prix'];
								}
								echo "<p>Votre image doit faire entre 2 et 100 crédits. Vous aviez fixé le prix à ".$textPrix."</p>";
							}
							echo '<br/></br>
							<input type="submit" value="Mettre en vente">
						</form><br/>';
						
				echo "<h2>Vos photographies</h2>";
				$br=1;
				$laBd=$db->query('select * from image where photographePseudo="'.$_SESSION['user'].'";');
				while($data=$laBd->fetch())
				{
					if($br<4)
					{
						echo '<a href="voirUneImage.php?idImage='.$data['idImg'].'"><img src="'.$data['lienImg'].'" height="25%" width="25%"></a>';
						$br++;
					}
					else
					{
						echo '<a href="voirUneImage.php?idImage='.$data['idImg'].'"><img src="'.$data['lienImg'].'" height="25%" width="25%"></a></br>';
						$br=1;
					}
					
				}
			}
			elseif($_SESSION['type']=="admin")
			{
				echo '<h2>Gestion Admin</h2>
				<p><a href="http://localhost/phpmyadmin/index.php">Accés à la base de données</a></p><br/>';
								
			}
		?>
		
    	<div class="clear"></div>
    </div>
    <?php include "include/footer.html";?>
</div>
</body>
</html>
