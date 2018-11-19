<?php
    session_start();
    $_SESSION['idPage']=2;
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

<?php include "include/head.php";?>
<body>
<div id="container">
<?php include "include/leMenu.php";?>
    <div id="body">
	
		<form action="recherchePhotoAchat.php" method="POST">
			<label>Categorie: </label>
			<select name="findCateg">
				<option value="all">Toutes</option>
				<?php $laBdCat=$db->query('select * from categorie;');
				while($dataCat=$laBdCat->fetch())
				{
					echo '<option value="'.$dataCat['nomCat'].'">'.$dataCat['nomCat'].'</option>';
				}
				?>
			</select>
			<input type="submit">
		</form>
		
		<?php
		
			if($_SESSION['user']==null)
			{
				include "include/coteDroit.php";
			}
			
			$br=1;
			
			if(!isset($_GET['categorie']) or $_GET['categorie']==null or $_GET['categorie']=="all")
			{
				$laBd=$db->query('select * from image;');
			}
			elseif(isset($_GET['categorie']) and $_GET['categorie']!=null)
			{
				$laBd=$db->query('select * from image,classer,categorie where idImg=idImage and idCategorie=idCat and nomCat="'.$_GET['categorie'].'";');
			}
			
			while($data=$laBd->fetch())
			{
				if($br<4)
				{
					echo '<a href="voirUneImage.php?idImage='.$data['idImg'].'"><img src="'.$data['lienImgProtec'].'" height="25%" width="25%"></a>';
					$br++;
				}
				else
				{
					echo '<a href="voirUneImage.php?idImage='.$data['idImg'].'"><img src="'.$data['lienImgProtec'].'" height="25%" width="25%"></a></br>';
					$br=1;
				}
				
			}
        
		?>
    	<div class="clear"></div>
    </div>
    <?php include "include/footer.html";?> 
</div>
</body>
</html>