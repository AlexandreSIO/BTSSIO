<?php 
	
	session_start(); 
	$_SESSION['idPage']=5;
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
		
        <form method="POST" action="inscrire.php">
            <h2>Inscription</h2><br/>
				<p>N'oubliez aucun champ</p>
				<p>Un compte client et un compte photographe par E-Mail</p>
                <label>EMail: </label><br/>
                <input type="text" name="mailReg"/>
				<?php 
				if(isset($_GET['dejaPrit']) and $_GET['dejaPrit']==true) 
				{
					echo "Utilisez une autre boite E-Mail pour ce compte";
				}
				if(isset($_GET['mailEmpty']) and $_GET['mailEmpty']==true)
				{
					echo "E-Mail oublié";
				}
				?>
				<br/><br/>
				
                <label>Nom: </label><br/>
                <input type="text" name="nomReg"/>
				<?php 
					if(isset($_GET['nameEmpty']) and $_GET['nameEmpty']==true)
					{
						echo "Nom oublié";
					}
				?>
				<br/><br/>
				
                <label>Prénom: </label><br/>
                <input type="text" name="prenomReg"/>
				<?php 
					if(isset($_GET['pnameEmpty']) and $_GET['pnameEmpty']==true)
					{
						echo "Prénom oublié";
					}
				?>
				<br/><br/>
				
				<label>Type de compte: </label><br/>
                <select name="typeReg">
					<option value="photographe">Photographe</option>
					<option value="client">Client</option>
				</select><br/><br/>
				
                <label>Pseudonyme: </label><br/>
                <input type="text" name="pseudoReg"/>
				<?php 
					if(isset($_GET['dejaPritPseudo']) and $_GET['dejaPritPseudo']==true)
					{
						echo "Pseudonyme deja utilisé";
					}
					
					if(isset($_GET['pseudoEmpty']) and $_GET['pseudoEmpty']==true)
					{
						echo "Pseudonyme necessaire";
					}
				?>
				<br/><br/>
				
				<p>Mot de passe entre 6 et 20 caracteres, avec au moins une majuscule, une minuscule et un chiffre</p>
				<label>Mot de passe: </label><br/>
				<input type="password" name="pswReg"/>
				<?php 
					if(isset($_GET['badPsw']) and $_GET['badPsw']==true)
					{
						echo "Le mot de passe ne respecte pas les contraintes de securité";
					}
				?>
				<br/><br/>
				
                <input type="submit"/>
        </form>
    	<div class="clear"></div>
    </div>
    <?php include "include/footer.html";?> 
</div>
</body>
</html>