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
		?>
    	<div class="clear"></div>
    </div>
    <?php include "include/footer.html";?> 
</div>
</body>
</html>
